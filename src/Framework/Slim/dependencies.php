<?php
// DIC configuration

use Gogordos\Application\Controllers\AddFriendController;
use Gogordos\Application\Controllers\AuthenticationController;
use Gogordos\Application\Controllers\CategoryController;
use Gogordos\Application\Controllers\FindUserController;
use Gogordos\Application\Controllers\GetAllRestaurantsController;
use Gogordos\Application\Controllers\GetRestaurantsOfFriendsController;
use Gogordos\Application\Controllers\RegisterController;
use Gogordos\Application\Controllers\AddRestaurantController;
use Gogordos\Application\Controllers\UserController;
use Gogordos\Application\Presenters\RestaurantPresenter;
use Gogordos\Application\Services\JwtAuthenticator;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantUseCase;
use Gogordos\Application\UseCases\AuthenticateUseCase;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsUseCase;
use Gogordos\Application\UseCases\GetUserRestaurants\GetUserRestaurantsUseCase;
use Gogordos\Application\UseCases\Login\LoginUseCase;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Gogordos\Framework\Config\CurrentVersion;
use Gogordos\Framework\Repositories\CategoryRepositoryMysql;
use Gogordos\Framework\Repositories\FriendRepositoryMysql;
use Gogordos\Framework\Repositories\RestaurantRepositoryMysql;
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

$container['CategoryRepository'] = function ($c) {
    return new CategoryRepositoryMysql(
        $c->get('Config')
    );
};

$container['CategoryController'] = function ($c) {
    return new CategoryController(
        $c->get('CategoryRepository')
    );
};

$container['RestaurantRepository'] = function ($c) {
    return new RestaurantRepositoryMysql(
        $c->get('Config')
    );
};

$container['AddRestaurantUseCase'] = function ($c) {
    return new AddRestaurantUseCase(
        $c->get('CategoryRepository'),
        $c->get('RestaurantRepository'),
        $c->get('Authenticator')
    );
};

$container['AddRestaurantController'] = function ($c) {
    return new AddRestaurantController(
        $c->get('AddRestaurantUseCase')
    );
};

$container['GetUserRestaurantsUseCase'] = function ($c) {
    return new GetUserRestaurantsUseCase(
        $c->get('UsersRepository'),
        $c->get('RestaurantRepository')
    );
};

$container['UserController'] = function ($c) {
    return new UserController(
        $c->get('GetUserRestaurantsUseCase')
    );
};

$container['GetAllRestaurantsController'] = function ($c) {
    return new GetAllRestaurantsController(
        $c->get('RestaurantRepository'),
        $c->get('RestaurantPresenter')
    );
};

$container['FindUserController'] = function ($c) {
    return new FindUserController(
        $c->get('UsersRepository')
    );
};

$container['FriendRepository'] = function ($c) {
    return new FriendRepositoryMysql(
        $c->get('Config')
    );
};

$container['AddFriendController'] = function ($c) {
    return new AddFriendController(
        $c->get('UsersRepository'),
        $c->get('FriendRepository'),
        $c->get('Authenticator')
    );
};

$container['RestaurantPresenter'] = function ($c) {
    return new RestaurantPresenter();
};

$container['GetRestaurantsOfFriendsUseCase'] = function ($c) {
    return new GetRestaurantsOfFriendsUseCase(
        $c->get('Authenticator'),
        $c->get('RestaurantRepository')
    );
};

$container['GetRestaurantsOfFriendsController'] = function ($c) {
    return new GetRestaurantsOfFriendsController(
        $c->get('GetRestaurantsOfFriendsUseCase')
    );
};
