<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Illustration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'boutique')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les catégories
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        // Récupérer toutes les illustrations
        $illustrations = $entityManager->getRepository(Illustration::class)->findAll();

        return $this->render('boutique/index.html.twig', [
            'categories' => $categories,
            'illustrations' => $illustrations,
        ]);
    }

    #[Route('/boutique/categorie/{id}', name: 'boutique_categorie')]
    public function category(EntityManagerInterface $entityManager, $id): Response
    {
        // Récupérer la catégorie spécifique
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        // Si la catégorie n'existe pas, rediriger vers la page boutique
        if (!$categorie) {
            return $this->redirectToRoute('boutique');
        }

        // Récupérer les illustrations liées à cette catégorie
        $illustrations = $entityManager->getRepository(Illustration::class)->findBy(['categorie' => $categorie]);

        // Récupérer toutes les catégories pour le filtre
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        return $this->render('boutique/index.html.twig', [
            'categories' => $categories,
            'illustrations' => $illustrations,
            'selectedCategory' => $categorie, // Pour mettre en avant la catégorie sélectionnée
        ]);
    }

    #[Route('/boutique/produit/{id}', name: 'fiche_produit')]
    public function ficheProduit($id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le produit en question
        $illustration = $entityManager->getRepository(Illustration::class)->find($id);

        // Récupérer des produits similaires (ex. même catégorie)
        $relatedProducts = $entityManager->getRepository(Illustration::class)
            ->findBy(['categorie' => $illustration->getCategorie()], null, 4);

        return $this->render('boutique/fiche_produit.html.twig', [
            'illustration' => $illustration,
            'related_products' => $relatedProducts,
        ]);
    }

   

}
