<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class StructureRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'nameStructure'
            ])
            ->add('email', null, [
                'label' => 'emailStructure'
            ])
            ->add('franchise', EntityType::class, [
                'class' => Franchise::class,
                'choice_label' => 'name',
                'label' => 'franchiseId'
            ])
            ->add('imageFile', VichImageType::class,[
                'required' => false
            ])
            ->add('address', null, [
                'label' => 'addressStructure'
            ])
            ->add('postalCode', null, [
                'label' => 'postalCodeStructure'
            ])
            ->add('city', null, [
                'label' => 'cityStructure'
            ])
            ->add('shortDescription', null, [
                'label' => 'shortDescription'
            ])
            ->add('fullDescription', null, [
                'label' => 'fullDescription'
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'active'
            ])
            ->add('wheySale', null, [
                'label' => 'wheySale'
            ])
            ->add('towelSale', null, [
                'label' => 'towelSale'
            ])
            ->add('drinkSale', null, [
                'label' => 'drinkSale'
            ])
            ->add('sauna', null, [
                'label' => 'sauna'
            ])
            ->add('paymentDay', null, [
                'label' => 'paymentDay'
            ])
            ->add('lateClosing', null, [
                'label' => 'lateClosing'
            ])
            ->add('sendNewsletter', null, [
                'label' => 'sendNewsletter'
            ])
            ->add('ringBoxe', null, [
                'label' => 'ringBoxe'
            ])
            ->add('crossfit', null, [
                'label' => 'crossfit'
            ])
            ->add('biking', null, [
                'label' => 'biking'
            ])/*
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class
        ]);
    }
}
