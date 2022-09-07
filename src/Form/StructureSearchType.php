<?php

namespace App\Form;

use App\Search\StructureSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'required' => false,
                'label' => 'nameStructure'
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
                'label' => 'cityStructure'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StructureSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}