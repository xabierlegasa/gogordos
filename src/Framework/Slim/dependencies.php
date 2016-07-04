<?php
// DIC configuration

use Gogordos\Application\Controllers\UsersController;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Gogordos\Framework\Repositories\UsersRepositoryMysql;
use Gogordos\Framework\Slim\Config;

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


// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};


//// Register slim/php-view component on container
//$container['view'] = function ($c) {
//    return new \Slim\Views\PhpRenderer('../templates/');
//};

//// twig
//$container['view'] = function ($container) {
//    $view = new \Slim\Views\Twig('../templates', [
//        //'cache' => '../templates/cache'
//        'cache' => false
//    ]);
//    $view->addExtension(new \Slim\Views\TwigExtension(
//        $container['router'],
//        $container['request']->getUri()
//    ));
//
//    return $view;
//};

$container['UsersRepository'] = function ($c) {
    /** @var Config $config */
    $config = $c->get('settings')['config'];
    return new UsersRepositoryMysql(
        $config
    );
};

$container['RegisterUserUseCase'] = function ($c) {
    return new RegisterUserUseCase(
        $c->get('UsersRepository')
    );
};

$container['UsersController'] = function ($c) {
    $registerUserUseCase = $c->get('RegisterUserUseCase');
    return new UsersController($registerUserUseCase);
};


