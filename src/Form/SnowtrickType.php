<?php

namespace App\Form;

use App\Entity\Snowtrick;
use App\Entity\TrickGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\NotBlank;

class SnowtrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre '
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'content'],
                'label' => 'Description ',
                'required' => false,
                'constraints' => [
                    new NotNull(message: 'Vous devez rentrer un contenu.')
                ]
            ])
            ->add('trickGroup', EntityType::class, [
                'class' => TrickGroup::class,
                'choice_label' => 'label ',
                'placeholder' => 'Sélectionnez',
                'label' => 'Difficulté'
            ])
            ->add('pictures', CollectionType::class, [
                'label' => 'Images',
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => [
                    new Count(min: 1, minMessage: 'Vous devez ajouter au moins une image.', groups: ['new', 'edit']),
                    new Valid()
                ]
            ])
            ->add('videos', CollectionType::class, [
                'label' => 'Vidéos',
                'entry_type' => VideoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => [
                    new Count(min: 1, minMessage: 'Vous devez ajouter au moins une vidéo.', groups: ['new', 'edit']),
                    new Valid()
                ]
            ])
            ->add('valider', SubmitType::class, [
                'label' => $options['button_label'],
                'attr' => ['class' => 'save btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Snowtrick::class,
            'validation_groups' => [],
            'button_label' => []
        ]);
    }
}
