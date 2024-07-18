<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email_cl', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'email@exemple.com'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'S3cr3T'
                    ],
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Veuillez saisir un mot de passe.'
                        ]),
                        new Assert\Length([
                            'min' => 6,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.'
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,}$/',
                            'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule, minuscule, un caractère spécial et un chiffre et faire plus de 8 caractères.'
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer le mot de passe'
                    ]
                    ],
                    'mapped' => false,
            ])
            ->add('firstname_cl', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Jean'
                ]
            ])
            ->add('lastname_cl', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Dupont'
                ]
            ])
            ->add('tel_cl', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '06 06 06 06 06'
                ]
            ]);

        if ($options['isAdmin']) {
            $builder->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
                ->remove('password');
        }

        if ($options['isEdit']) {
            $builder->add('tel_cl', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '06 06 06 06 06'
                ]
            ])
                ->add('birthdate_cl', DateType::class, [
                    'label' => 'Date de naissance',
                    'attr' => [
                        'placeholder' => 'jj/mm/aaaa'
                    ],
                    'required' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'isAdmin' => false,
            'isEdit' => false,
        ]);
    }
}
