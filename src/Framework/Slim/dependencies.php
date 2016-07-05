<?php
// DIC configuration

use Gogordos\Application\Controllers\UsersController;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Gogordos\Domain\Services\Authenticator;
use Gogordos\Framework\Config\CurrentVersion;
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
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

$container['Config'] = function ($c) {
    /** @var Config $config */
    $config = $c->get('settings')['config'];

    return $config;
};

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['Authentication'] = function ($c) {
    return new Authenticator(
        new \Lcobucci\JWT\Builder()
    );
};

$container['UsersRepository'] = function ($c) {
    return new UsersRepositoryMysql(
        $c->get('Config')
    );
};

$container['RegisterUserUseCase'] = function ($c) {
    return new RegisterUserUseCase(
        $c->get('UsersRepository'),
        $c->get('Authentication')
    );
};

$container['UsersController'] = function ($c) {
    return new UsersController(
        $c->get('RegisterUserUseCase')
    );
};

$container['CurrentVersion'] = function ($c) {
    return new CurrentVersion(
        $c->get('Config'),
        $c->get('logger')
    );
};


