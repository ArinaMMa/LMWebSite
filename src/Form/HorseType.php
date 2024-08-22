<?php

namespace App\Form;

use App\Entity\Vet;
use App\Entity\Horse;
use App\Entity\Client;
use App\Entity\Breeder;
use App\Entity\DonePrestations;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class HorseType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_ho', TextType::class, [
                'label' => 'Nom du cheval', 
                'attr' => [
                    'placeholder' => 'Nom du cheval'
                ],
                'required' => true,
            ])
            ->add('birthdate_ho', DateType::class, [
                'label' => 'Date de naissance',
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa'
                ],
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('sex_ho', ChoiceType::class, [
                'label' => 'Sexe du cheval',
                'choices' => [
                    'Mâle' => 'Mâle',
                    'Femelle' => 'Femelle',
                    'Hongre' => 'Hongre',
                ],
            ])
            ->add('breed_ho', TextType::class, [
                'label' => 'Race du cheval', 
                'attr' => [
                    'placeholder' => 'Race du cheval'
                ]
            ])
            ->add('pictureFile', VichImageType::class, [
                'label' => 'Photo du cheval',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => false,
            ])  
            ->add('breeder', EntityType::class, [
                'class' => Breeder::class,
                'choice_label' => 'name_br',
                'label' => 'Eleveur',
                'placeholder' => 'Choisir un éleveur',
                'multiple' => false,
            ])
            // ->add('done_prestation', EntityType::class, [
            //     'class' => DonePrestations::class,
            // 'label' => 'Prestations effectuées',
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            ->add('vets', EntityType::class, [
                'class' => Vet::class,
                'choice_label' => 'lastname_vet',
                'label' => 'Vétérinaire(s)',
                'placeholder' => 'Choisir un vétérinaire',
                'multiple' => true,
            ])
        ;
        //affichage uniquement si rôle admin
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'lastname_cl',
                'placeholder' => 'Choisir un client',
                'multiple' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horse::class,
        ]);
    }
}
