<?php

namespace App\Controller\Admin;

use App\Entity\Illustration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class IllustrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Illustration::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Cache l'ID dans le formulaire
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description'),
            NumberField::new('price', 'Prix'),
            
            // Upload drag & drop pour les images
            ImageField::new('image1', 'Image 1')
                ->setUploadDir('public/uploads/illustrations/')
                ->setBasePath('/uploads/illustrations/')
                ->setRequired(true),
            ImageField::new('image2', 'Image 2')
                ->setUploadDir('public/uploads/illustrations/')
                ->setBasePath('/uploads/illustrations/')
                ->setRequired(false),
            ImageField::new('image3', 'Image 3')
                ->setUploadDir('public/uploads/illustrations/')
                ->setBasePath('/uploads/illustrations/')
                ->setRequired(false),
            
            // Champ pour la catégorie (relation ManyToOne)
            AssociationField::new('categorie', 'Catégorie')
        ];
    }
}