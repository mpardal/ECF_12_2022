<?php

namespace App\Form;

use App\Search\FranchiseSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'required' => false,
                'label' => 'nameFranchise'
            ])
            ->add('active', ChoiceType::class, [
                'choices' => [
                    'Salle non active' => false,
                    'Salle active' => true
                ],
                'required' => false,
                'expanded' => true
            ])
            ->add('city', null, [
                'required' => false,
                'label' => 'cityFranchise'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FranchiseSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}