<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Vehicle;
use App\Repository\BrandRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mileAge')
            ->add('yearManufacture')
            ->add('doorNumber')
            ->add('horsePower')
            ->add('seatNumber')
            ->add('price')
            ->add('vehicleCondition', ChoiceType::class, [
                'choices' => [
                    'Select a value' => '',
                    'Neuf' => 'Neuf',
                    'Restauré' => 'Restauré',
                    'Occasion' => 'Occasion'
                    /*'Original Condition' =>'Original Condition',
                    'Restored' => 'Restored',
                    'Used with guarantee' => 'Used with guarantee',
                    'Used' => 'Used',
                    'New' => 'New'*/
                ]
            ])
            ->add('gearBoxType', ChoiceType::class, [
                'choices' => [
                    'Manual' =>'Manual',
                    'Automatic' => 'Automatic',
                    'Semi-automatic' => 'Semi-automatic'
                ]
            ])
            ->add('fuelType', ChoiceType::class, [
                'choices' => [
                    'Diesel' => 'Diesel',
                    'Gas' => 'Gas',
                    'Ethanol' => 'Ethanol',
                    'Hybrid' => 'Hybrid',
                    'Other' => 'Other'
                ]
            ])
            ->add('color')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'delete_label' => "Supprimer l'image",
                'download_uri' => false,
                'image_uri' => false])

            ->add('registrationNumber')
            ->add('model')
            /*->add('brandName', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => function (Brand $brand) {
                    return $brand->getName();
                }
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
