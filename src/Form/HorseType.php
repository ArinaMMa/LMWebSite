<?php

namespace App\Form;

use App\Entity\Vet;
use App\Entity\Horse;
use App\Entity\Client;
use App\Entity\Breeder;
use App\Entity\DonePrestations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HorseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('breed_ho', TextType::class, [
                'label' => 'Race du cheval', 
                'attr' => [
                    'placeholder' => 'Race du cheval'
                ]
            ])
            ->add('sex_ho')
            ->add('birthdate_ho', DateType::class, [
                'label' => 'Date de naissance',
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa'
                ],
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('name_ho', TextType::class, [
                'label' => 'Nom du cheval', 
                'attr' => [
                    'placeholder' => 'Nom du cheval'
                ],
                'required' => true,
            ])
            // ->add('picture_ho', VichImageType::class, [
            //     'label' => 'Photo du cheval',
            //     'required' => false,
            //     'allow_delete' => false,
            //     'download_uri' => false,
            //     'image_uri' => true,
            //     'asset_helper' => false,
            // ])   
            ->add('breeder_ho', EntityType::class, [
                'class' => Breeder::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('done_prestation_id', EntityType::class, [
                'class' => DonePrestations::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('vet_id', EntityType::class, [
                'class' => Vet::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horse::class,
        ]);
    }
}
