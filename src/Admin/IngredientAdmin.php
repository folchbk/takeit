<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class IngredientAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('kcal')
            ->add('proteins')
            ->add('carbohydrates')
            ->add('fat')
            ->add('stock')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('kcal')
            ->add('proteins')
            ->add('carbohydrates')
            ->add('fat')
            ->add('stock')
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
            ->add('name')
            ->add('kcal')
            ->add('proteins')
            ->add('carbohydrates')
            ->add('fat')
            ->add('stock')
            ->add('local')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('kcal')
            ->add('proteins')
            ->add('carbohydrates')
            ->add('fat')
            ->add('stock')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ;
    }
}
