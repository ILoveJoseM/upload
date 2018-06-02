<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 23:28
 */

namespace ServiceProvider;


use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Service\SessionService;

class SessionServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // TODO: Implement register() method.
        $container->add("session",new SessionService());
    }
}