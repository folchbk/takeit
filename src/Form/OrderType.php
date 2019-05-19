<?php

namespace App\Form;

use App\Entity\Order;
use App\Repository\ClientRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', null, [
                'query_builder' => function (ClientRepository $clientRepository) {
                    return $clientRepository->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'pending',
                    'Cooking' => 'cooking',
                    'Payed' => 'payed'
                ]
            ])
            ->add('orderProducts', CollectionType::class, [
                    'label' => '',
                    'entry_type' => OrderProductType::class,
                    'entry_options' => array('label' => false),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => true,
                    'attr' => array('class' => 'form-control')]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
