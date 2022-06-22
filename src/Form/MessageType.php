<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class,[
                'required' => true,
                'label' => 'your message*'
            ])
            ->add('creationDate', DateType::class,[
                'required' => 'false',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('topics', EntityType::class, [
                'class' => Topic::class,
                'choice_label' => 'getTitle'
            ])/*
            ->add('users', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'getFirstname'
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
