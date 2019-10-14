<?php

use App\Controller\HomeWorkController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('home_work_show', '/homework/show/{id<\d+>}')
        ->controller([HomeWorkController::class, 'show']);
};
