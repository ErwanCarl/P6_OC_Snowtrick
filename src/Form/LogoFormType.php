<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LogoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logoChoice', ChoiceType::class, [
                'label' => 'Choix du logo',
                'required' => true,
                'choices'  => [
                    'choice-1' => 'user.png',
                    'choice-2' => 'user-2.png',
                    'choice-3' => 'bonsai.png',
                    'choice-4' => 'doc.png',
                    'choice-5' => 'drawing.png',
                    'choice-6' => 'epee.png',
                    'choice-7' => 'flower.png',
                    'choice-8' => 'globe.png',
                    'choice-9' => 'heart.png',
                    'choice-10' => 'horla.png',
                ],
                'choice_attr' => [
                    'choice-1' => ['class' => 'radio-image', 'data-image' => '/users_logo/user.png'],
                    'choice-2' => ['class' => 'radio-image', 'data-image' => '/users_logo/user-2.png'],
                    'choice-3' => ['class' => 'radio-image', 'data-image' => '/users_logo/bonsai.png'],
                    'choice-4' => ['class' => 'radio-image', 'data-image' => '/users_logo/doc.png'],
                    'choice-5' => ['class' => 'radio-image', 'data-image' => '/users_logo/drawing.png'],
                    'choice-6' => ['class' => 'radio-image', 'data-image' => '/users_logo/epee.png'],
                    'choice-7' => ['class' => 'radio-image', 'data-image' => '/users_logo/flower.png'],
                    'choice-8' => ['class' => 'radio-image', 'data-image' => '/users_logo/globe.png'],
                    'choice-9' => ['class' => 'radio-image', 'data-image' => '/users_logo/heart.png'],
                    'choice-10' => ['class' => 'radio-image', 'data-image' => '/users_logo/horla.png'],
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('ajouter', SubmitType::class, [
                'label' => 'Confirmer le choix',
                'attr' => ['class' => 'save btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}