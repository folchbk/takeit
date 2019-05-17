<?php

namespace App\Form;

use App\Entity\Local;
use App\Repository\DealRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('phone')
            ->add('city')
            ->add('street')
            ->add('cp')
            ->add('numEmployees')
            ->add('enabled')
            ->add('deal', null, [
                'query_builder' => function (DealRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Local::class,
        ]);
    }
}
