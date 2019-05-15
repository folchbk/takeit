<?php

namespace App\Form;

use App\Entity\ProductIngredient;
use App\Repository\IngredientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredient', null, [
                'query_builder' => function(IngredientRepository $repo) { return $repo->createAlphabeticalQueryBuilder();},
                'attr' => [
                    'class' => 'form-control col-xs-4',
                ]

                ])
            ->add('quantity', null, [
                'attr' => ['class' => 'form-control col-xs-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductIngredient::class,
        ]);
    }

}
