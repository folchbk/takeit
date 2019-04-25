<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class MenuAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('menu', null, ['multiple' => false, 'label' => 'Menu'])
            ->add('product', null, ['multiple' => true, 'label' => 'Products'])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('quantity')
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
            ->add('menu', null, ['multiple' => false, 'label' => 'Menu'])
            ->add('product', null, ['multiple' => false, 'label' => 'Products'])
            ->add('quantity')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('menu', null, ['multiple' => false, 'label' => 'Menu'])
            ->add('product', null, ['multiple' => true, 'label' => 'Products'])
            ->add('quantity')
            ;
    }
}
