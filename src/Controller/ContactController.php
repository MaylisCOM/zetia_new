<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactController extends AbstractController
{
#[Route('/contact/send', name: 'contact_send', methods: ['POST'])]
public function send(Request $request, MailerInterface $mailer, SessionInterface $session): Response
{
// Validation des données
$name = htmlspecialchars($request->request->get('name'));
$email = htmlspecialchars($request->request->get('email'));
$service = htmlspecialchars($request->request->get('service'));
$phone = htmlspecialchars($request->request->get('phone'));
$message = htmlspecialchars($request->request->get('message'));

// Vérification basique pour éviter les spams
if (empty($name) || empty($email) || empty($message)) {
$this->addFlash('error', 'Veuillez remplir tous les champs.');
return $this->redirectToRoute('contact');
}

// Créer l'email
$emailMessage = (new Email())
->from($email)
->to('dfarkas960@gmail.com')
->subject('Nouveau message de contact')
->html("
<p><strong>Nom :</strong> {$name}</p>
<p><strong>Email :</strong> {$email}</p>
<p><strong>Prestations :</strong> {$service}</p>
<p><strong>Téléphone :</strong> {$phone}</p>
<p><strong>Message :</strong></p>
<p>{$message}</p>
");

// Envoyer l'email
$mailer->send($emailMessage);

// Confirmation de l'envoi
$this->addFlash('success', 'Votre message a bien été envoyé !');

// Redirection après envoi
return $this->redirectToRoute('contact');
}
}
