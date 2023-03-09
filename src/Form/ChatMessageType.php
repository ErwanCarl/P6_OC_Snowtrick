<?php

namespace App\Form;

use App\Entity\ChatMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ChatMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => ' ',
                'attr' => ['class' => 'tinymce'],
                'sanitize_html' => true,
                'constraints' => [
                    new NotBlank(message: 'Vous devez rentrer un message.'),
                ],
            ])
            ->add('envoyer', SubmitType::class, [
                'label' => 'Laisser un commentaire',
                'attr' => ['class' => 'save btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChatMessage::class,
        ]);
    }
}
