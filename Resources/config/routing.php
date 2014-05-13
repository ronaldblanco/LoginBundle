<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('AcmeLoginBundle_homepage', new Route('/hello/{name}', array(
    '_controller' => 'AcmeLoginBundle:Default:index',
)));

return $collection;
