<?php
namespace App\Form;

use App\Entity\Categories;
use App\Entity\Editeur;
use App\Entity\Auteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class BookFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'designation',
                'multiple' => true,
                'expanded' => true, // Display as checkboxes
            ])
            ->add('authors', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => fn($author) => $author->getNom() . ' ' . $author->getPrenom(),
                'multiple' => true,
                'expanded' => true, // Display as checkboxes
            ])
            ->add('editors', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true, // Display as checkboxes
            ])
            /*->add('price', RangeType::class, [
                'attr' => ['min' => 0, 'max' => 1000],
                'required' => false,])*/
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
