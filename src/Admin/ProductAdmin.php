<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductIngredient;
use App\Form\ImageType;
use App\Form\OrderProductType;
use App\Form\TypeProductType;

use App\Form\ProductIngredientType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('category')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('category')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('image')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('type')
            ->add('productIngredients', CollectionType::class, array(
                'label' => 'Ingredients',
                'entry_type' => ProductIngredientType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false
                )
            )
            ->add('category')
            ->add('type')
            ->add('image',ImageType::class, array('data_class' => null))


//            ->add('productIngredients', null, [
//                'multiple' => true,
//                'label' => 'Ingredients',
//                'group_by' => 'product'
//            ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('category')
            ->add('productIngredients', null, ['label' => 'Ingredients'])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt');
    }

}
