<?php
// DIC configuration

use Gogordos\Application\Controllers\UsersController;
use Gogordos\Application\UseCases\RegisterUserUseCase;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


// twig
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates', [
        //'cache' => '../templates/cache'
        'cache' => false
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};


$container['RegisterUserUseCase'] = function ($c) {
    return new RegisterUserUseCase();
};

$container['UsersController'] = function ($c) {
    $registerUserUseCase = $c->get('RegisterUserUseCase');
    return new UsersController($registerUserUseCase);
};


