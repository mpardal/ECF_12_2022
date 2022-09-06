<?php

namespace App\Form;

use App\Entity\Franchise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FranchiseRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'nameFranchise'
            ])
            ->add('email', null, [
                'label' => 'emailFranchise'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false
            ])
            ->add('city', null, [
                'label' => 'cityFranchise'
            ])
            ->add('active', null, [
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Franchise::class
        ]);
    }
}
