<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Editeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('nbrpage')
            ->add('dateEdition', null, [
                'widget' => 'single_text',
            ])
            ->add('nbrexemplaire')
            ->add('prix')
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'designation',
            ])
            // Ajout de l'éditeur (ManyToOne)
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nom', // Utilisez le champ que vous voulez afficher pour l'éditeur
            ])
            // Ajout des auteurs (ManyToMany)
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'multiple' => true,
                'expanded' => false, // false pour un select multiple, true pour des cases à cocher
                'choice_label' => 'nom', // Utilisez le champ que vous voulez afficher pour l'auteur
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Upload Image',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
