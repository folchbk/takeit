<?php

declare(strict_types=1);

namespace App\Admin;

use App\Form\OrderProductType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

final class OrderAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('client',null,['multiple' => false, 'label' => 'Client'])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('client',null,['multiple' => false, 'label' => 'Client'])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
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
            ->add('client',null,['multiple' => false, 'label' => 'Client'])
            ->add('orderProducts', CollectionType::class, array(
                'label' => 'Products',
                'entry_type' => OrderProductType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false
            ))
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('client',null,['multiple' => false, 'label' => 'Client'])
            ->add('orderProducts',null,['multiple' => true, 'label' => 'Products'])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ;
    }
}
