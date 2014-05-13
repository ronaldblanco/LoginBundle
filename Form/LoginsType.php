<?php

namespace Acme\Bundle\LoginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LoginsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('descripcion')
            ->add('act')
            ->add('adm')
            ->add('loock')
            ->add('iphost')
            ->add('theme')
        ;
    }

    public function getName()
    {
        return 'acme_bundle_loginbundle_loginstype';
    }
}
