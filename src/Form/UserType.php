<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Your mail*'
            ])
            ->add('roles')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identique',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first-options' => ['label' => 'Password*'],
                'second-options' => ['label' => 'Confirm your password*'],

                'constraints' => [
                    new NotBlank(['message' => 'A password is necessary']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password is minimum {{limit}} caracthers',
                        'max' => 20,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Firstname*'
            ])
            ->add('lastname', TextType::class,[
                'required' => false,
                'label' => 'Lastname'
            ])
            ->add('nickname', TextType::class,[
                'required' => true,
                'label' => 'Your nickname*'
            ])
            ->add('creationDate', DateType::class, [
                'required' => false, 
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
