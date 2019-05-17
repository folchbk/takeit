<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\LocalRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('username')
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                'attr' => array(
                    'type' => 'password',
                ),
                'required' => false
            ])
            ->add('phone')
            ->add('city')
            ->add('cp')
            ->add('street')
            ->add('iban')
            ->add('locals', null, [
                'query_builder' => function(LocalRepository $repo) { return $repo->createAlphabeticalQueryBuilder();},
                'required' => true,
            ])
            ->add('enabled')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
