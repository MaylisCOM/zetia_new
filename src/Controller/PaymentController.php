<?php

namespace App\Controller;

use App\Entity\User;
use App\Classe\Cart;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/commande/paiement/{id_order}', name: 'app_payment')]
    public function index($id_order, OrderRepository $orderRepository, EntityManagerInterface $entityManager): Response
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        $order = $orderRepository->findOneBy([
            'id' => $id_order,
            'user' => $this->getUser()
        ]);

        if (!$order) {
            return $this->redirectToRoute('app_home');
        }

        $products_for_stripe = [];

        foreach ($order->getOrderDetails() as $product) {
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => intval($product->getProductPrice() * 100),
                    'product_data' => [
                        'name' => mb_convert_encoding($product->getProductName(), 'UTF-8', 'auto'),
                        'images' => [
                            $_ENV['DOMAIN'].'/uploads/illustrations/'.rawurlencode($product->getProductIllustration())
                        ]

                    ]
                ],
                'quantity' => intval($product->getProductQuantity()),
            ];
        }

        /** @var User $user */
        $user = $this->getUser();
        
        $success_url = $_ENV['DOMAIN'] . '/commande/merci/' . '{CHECKOUT_SESSION_ID}';
        $cancel_url = $_ENV['DOMAIN'] . '/mon-panier/annulation';

        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'line_items' => $products_for_stripe,
            'mode' => 'payment',
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        return $this->redirect($checkout_session->url);
    }

    #[Route('/commande/merci/{stripe_session_id}', name: 'app_payment_success')]
    public function success($stripe_session_id, OrderRepository $orderRepository, EntityManagerInterface $entityManager, Cart $cart, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw new \LogicException('User is not authenticated.');
        }

        // Debugging: Check the session ID
        $sessionId = $request->getSession()->getId();
        dump($sessionId);

        $order = $orderRepository->findOneBy([
            'stripe_session_id' => $stripe_session_id,
            'user' => $user
        ]);

        if (!$order) {
            return $this->redirectToRoute('app_home');
        }

        if ($order->getState() == 1) {
            $order->setState(2);
            $cart->reset();
            $entityManager->flush();
        }

        return $this->render('payment/success.html.twig', [
            'order' => $order,
        ]);
    }
}