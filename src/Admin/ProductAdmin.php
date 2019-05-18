<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Image;
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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductAdmin extends AbstractAdmin
{

    public function prePersist($product)
    {
        $this->manageEmbeddedImageAdmins($product);
    }

    public function preUpdate($product)
    {
        $this->manageEmbeddedImageAdmins($product);
    }

    private function manageEmbeddedImageAdmins($product)
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldDescription->getType() === 'App\Form\ImageType' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'App\Entity\Image'
            ) {
                $getter = 'get'.$fieldName;
                $setter = 'set'.$fieldName;

                /** @var Image $image */
                $image = $product->$getter();

                if ($image) {
                    if ($image->getFile()) {
                        // update the Image to trigger file management
                        $image->refreshUpdated();
                    } elseif (!$image->getFile() && !$image->getFilename()) {
                        // prevent Sf/Sonata trying to create and persist an empty Image
                        $product->$setter(null);
                    }
                }
            }
        }
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('local')
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
            ->add('local')
            ->add('glutenFree')
            ->add('category')
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
            ->add('local')
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('type')
            ->add('glutenFree')
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
            ->add('image', ImageType::class, [
                'required' => false
            ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('category')
            ->add('local')
            ->add('productIngredients', null, ['label' => 'Ingredients'])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt');
    }
}
