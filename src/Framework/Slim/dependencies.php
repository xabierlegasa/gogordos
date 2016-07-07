<?php
// DIC configuration

use Gogordos\Application\Controllers\AuthenticationController;
use Gogordos\Application\Controllers\RegisterController;
use Gogordos\Application\Services\JwtAuthenticator;
use Gogordos\Application\UseCases\AuthenticateUseCase;
use Gogordos\Application\UseCases\Login\LoginUseCase;
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

$container['UsersRepository'] = function ($c) {
    return new UsersRepositoryMysql(
        $c->get('Config')
    );
};

$container['RegisterUserUseCase'] = function ($c) {
    return new RegisterUserUseCase(
        $c->get('UsersRepository'),
        $c->get('Authenticator')
    );
};

$container['RegisterController'] = function ($c) {
    return new RegisterController(
        $c->get('RegisterUserUseCase')
    );
};

$container['CurrentVersion'] = function ($c) {
    return new CurrentVersion(
        $c->get('Config'),
        $c->get('logger')
    );
};

$container['Authenticator'] = function ($c) {
    return new JwtAuthenticator(
        new \Lcobucci\JWT\Builder(),
        $c->get('logger')
    );
};

$container['AuthenticateUseCase'] = function ($c) {
    return new AuthenticateUseCase(
        $c->get('Authenticator')
    );
};


$container['AuthenticationController'] = function ($c) {
    return new AuthenticationController(
        $c->get('AuthenticateUseCase')
    );
};

$container['LoginUseCase'] = function ($c) {
    return new LoginUseCase(
        $c->get('UsersRepository')
    );
};
