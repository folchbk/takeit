<?php

namespace App\Form;

use App\Entity\Product;
use App\Repository\CategoryProductRepository;
use PhpParser\ErrorHandler\Collecting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('description')
            ->add('category', null, [
                'group_by' => 'categoryProduct',
                'query_builder' => function (CategoryProductRepository $categoryProductRepository) {
                    return $categoryProductRepository->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('productIngredients', CollectionType::class, array(
                    'label' => '',
                    'entry_type' => ProductIngredientType::class,
                    'entry_options' => array('label' => false),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add('image', ImageType::class, []);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
