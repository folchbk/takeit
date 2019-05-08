<?php

declare(strict_types=1);

namespace App\Admin;

use Elastica\Query\Match;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class DealAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('cif')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add('cif')
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
            ->add('cif')
            ->add('users', null, ['multiple' => true, 'label' => 'Users'])
            ->add('enabled');
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add('cif')
            ->add('locals')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('enabled');
    }

//    public function createQuery($context = 'list')
//    {
//        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
//        $deals = $user->getDeals();
//
//        $query = parent::createQuery($context);
//        if ($deals[0] == null) {
//            $query->andWhere('1 != 1');
//            return $query;
//        }
//        return $query;
//    }
}
