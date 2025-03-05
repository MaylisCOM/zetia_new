<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            ImageField::new('logo', 'Logo')
                ->setUploadDir('public/uploads/logos')
                ->setBasePath('uploads/logos')
                ->setRequired(false),
            TextEditorField::new('description', 'Description'),
            AssociationField::new('illustrations', 'Illustrations')
                ->hideOnForm()
                ->formatValue(fn ($value) => $value && !$value->isEmpty() 
                    ? implode(', ', $value->map(fn($illustration) => $illustration->getName())->toArray()) 
                    : ''
                ),
        ];
    }
}
