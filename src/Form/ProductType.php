<?php

namespace App\Form;

use App\Entity\Product;
use PhpParser\ErrorHandler\Collecting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sonata\AdminBundle\Form\FormMapper;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('productIngredients', CollectionType::class, array(
                    'label' => 'Ingredients',
                    'entry_type' => ProductIngredientType::class,
                    'entry_options' => array('label' => true),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => true
                )
            )
//        ->add('productIngredients')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
