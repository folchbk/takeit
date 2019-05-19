<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Disccount;
use App\Form\DisccountType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

final class LocalAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('phone')
            ->add('street')
            ->add('city')
            ->add('cp')
            ->add('numEmployees')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('enabled')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('deal')
            ->add('name')
            ->add('phone')
            ->add('street')
            ->add('city')
            ->add('cp')
            ->add('numEmployees')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('enabled')
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
            ->add('phone')
            ->add('deal',null,  ['multiple'=>false, 'label' => 'Deal'])
            ->add('street')
            ->add('city')
            ->add('cp')
            ->add('numEmployees')
            ->add('disccounts',CollectionType::class, array(
                'entry_type' => DisccountType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false
            ))
            ->add('enabled')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('phone')
            ->add('street')
            ->add('city')
            ->add('cp')
            ->add('numEmployees')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('enabled')
            ;
    }
}
