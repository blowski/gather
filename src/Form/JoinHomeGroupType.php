<?php

namespace App\Form;

use App\Entity\HomeGroup;
use App\Validators\HomeGroupWithCodeMustExist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoinHomeGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null, [
                'constraints' => [
                    new HomeGroupWithCodeMustExist()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
