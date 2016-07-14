<?php

use Gogordos\Application\Controllers\AccountController;
use Gogordos\Application\Controllers\AuthenticationController;
use Gogordos\Application\Controllers\CategoryController;
use Gogordos\Application\Controllers\LoginController;
use Gogordos\Application\Controllers\RegisterController;
use Gogordos\Application\Controllers\RestaurantController;
use Gogordos\Framework\Config\CurrentVersion;
use Psr\Http\Message\ResponseInterface;

// Routes

$app->get('/', function ($request, $response, $args) {

    /** @var CurrentVersion $currentVersion */
    $currentVersion = $this->CurrentVersion;

    return $this->renderer->render($response, 'index.phtml', [
        "router" => $this->router,
        "version" => $currentVersion->get()
    ]);
})->setName("home");;

$app->post('/api/users', function ($request, ResponseInterface $response, $args) {
    $registerController = new RegisterController($this->get('RegisterUserUseCase'));
    $data = $registerController->register($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($data, 200);

    return $response;
})->setName('signUp');

$app->get('/api/auth', function ($request, ResponseInterface $response, $args) {
    $authenticationController = new AuthenticationController($this->get('AuthenticateUseCase'));
    $data = $authenticationController->authenticate($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($data, 200);

    return $response;
})->setName('getUserFromJWT');

$app->post('/api/login', function ($request, ResponseInterface $response, $args){
    $loginController = new LoginController(
        $this->get('LoginUseCase'),
        $this->get('Authenticator')
    );
    $data = $loginController->login($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($data, 200);

    return $response;
});

$app->get('/api/account', function ($request, ResponseInterface $response, $args){
    $accountController = new AccountController(
        $this->get('AuthenticateUseCase'),
        $this->get('UsersRepository')
    );
    $response = $accountController->getAccount($request, $response);

    return $response;
});

$app->get('/api/restaurants', function ($request, ResponseInterface $response, $args){
    $restaurantController = new RestaurantController(
        $this->get('RestaurantsRepository')
    );
    
    /** @var JsonResponse $response */
    $jsonResponse = $restaurantController->addRestaurant($request, $response);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($jsonResponse->data(), $jsonResponse->httpCode());
    
    return $response;
});

$app->get('/api/categories', function ($request, ResponseInterface $response, $args){
    $categoryController = new CategoryController(
        $this->get('CategoryRepository')
    );
    
    $ctrlResponse = $categoryController->getAllCategories();
    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($ctrlResponse->data(), $ctrlResponse->httpCode());
    
    return $response;
});
