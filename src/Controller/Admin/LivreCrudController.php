<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('titre'),
            IntegerField::new('nbrpage'),
            DateField::new('dateEdition'),
            IntegerField::new('nbrexemplaire')->setRequired(false),
            NumberField::new('prix')->setNumDecimals(2),

            AssociationField::new('editeur')->setFormTypeOptions([
                'by_reference' => false,
            ]),
            AssociationField::new('auteurs')->setFormTypeOptions([
                'by_reference' => false,
            ]),
            AssociationField::new('categories')->setFormTypeOptions([
                'by_reference' => false,
            ]),
            ImageField::new('image')
                ->setBasePath('/uploads/livres')  // Path for displaying images
                ->setUploadDir('public/uploads/livres')  // Directory for storing images
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false),
        ];
    }
}