<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'acme_login.example',
    new Definition(
        'Acme\Bundle\LoginBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/