<?php

namespace App\Form;

use App\Entity\Franchise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            ->add('password', PasswordType::class, [
                'required' => false,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'passwordFranchise',
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => "Entrez un mot de passe s'il vous plait",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être entre {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('address', null, [
                'label' => 'addressFranchise'
            ])
            ->add('postalCode', null, [
                'label' => 'postalCodeFranchise'
            ])
            ->add('city', null, [
                'label' => 'cityFranchise'
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
            ])



            /*
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
            'data_class' => Franchise::class,
        ]);
    }
}
