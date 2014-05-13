<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('accesos', new Route('/', array(
    '_controller' => 'AcmeLoginBundle:Logins:index',
)));

$collection->add('accesos_show', new Route('/{id}/show', array(
    '_controller' => 'AcmeLoginBundle:Logins:show',
)));

$collection->add('accesos_new', new Route('/new', array(
    '_controller' => 'AcmeLoginBundle:Logins:new',
)));

$collection->add('accesos_create', new Route(
    '/create',
    array('_controller' => 'AcmeLoginBundle:Logins:create'),
    array('_method' => 'post')
));

$collection->add('accesos_edit', new Route('/{id}/edit', array(
    '_controller' => 'AcmeLoginBundle:Logins:edit',
)));

$collection->add('accesos_update', new Route(
    '/{id}/update',
    array('_controller' => 'AcmeLoginBundle:Logins:update'),
    array('_method' => 'post')
));

$collection->add('accesos_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AcmeLoginBundle:Logins:delete'),
    array('_method' => 'post')
));

return $collection;
