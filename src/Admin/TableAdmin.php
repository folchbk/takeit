<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Session\Session;
use Sonata\AdminBundle\Route\RouteCollection;

final class TableAdmin extends AbstractAdmin
{

    protected $parentAssociationMapping = 'table_id';

    protected function configureRoutes(RouteCollection $collection)
    {
        if ($this->isChild()) {
            return;
        }

        // This is the route configuration as a parent
        $collection->clear();
    }
        protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('tableCode')
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
            ->add('tableCode')
            ->add('type')
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
//            ->add('id')
            ->add('tableCode')
            ->add('local', null, ["multiple" => false, "label" => "Local"])
            ->add('type')
            ->add('enabled')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('tableCode')
            ->add('type')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('enabled')
            ;
    }
}
