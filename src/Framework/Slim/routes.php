<?php

use Gogordos\Application\Controllers\AccountController;
use Gogordos\Application\Controllers\AuthenticationController;
use Gogordos\Application\Controllers\GetAllRestaurantsController;
use Gogordos\Application\Controllers\LoginController;
use Gogordos\Application\Controllers\RegisterController;
use Gogordos\Application\Controllers\AddRestaurantController;
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



$app->get('/api/users', function ($request, ResponseInterface $response, $args) {
    /** @var FindUserController $findUserController */
    $findUserController = $this->get('FindUserController');

    /** @var JsonResponse $response */
    $jsonResponse = $findUserController->findUsersByTerm($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($jsonResponse->data(), $jsonResponse->httpCode());

    return $response;
})->setName('findUserByTerm');

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
    $jsonResponse = $loginController->login($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($jsonResponse->data(), $jsonResponse->httpCode());

    return $response;
});

$app->get('/api/account', function ($request, ResponseInterface $response, $args){
    $accountController = new AccountController(
        $this->get('AuthenticateUseCase'),
        $this->get('UsersRepository')
    );
    $jsonResponse = $accountController->getAccount($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($jsonResponse->data(), $jsonResponse->httpCode());

    return $response;
});

$app->post('/api/restaurants', function ($request, ResponseInterface $response, $args){
    $addRestaurantController = new AddRestaurantController(
        $this->get('AddRestaurantUseCase')
    );

    /** @var JsonResponse $response */
    $jsonResponse = $addRestaurantController->addRestaurant($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($jsonResponse->data(), $jsonResponse->httpCode());

    return $response;
});

$app->get('/api/restaurants', function ($request, ResponseInterface $response, $args){
    /** @var GetAllRestaurantsController $getAllRestaurantsController */
    $getAllRestaurantsController = $this->get('GetAllRestaurantsController');

    /** @var JsonResponse $response */
    $jsonResponse = $getAllRestaurantsController->getRestaurants($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($jsonResponse->data(), $jsonResponse->httpCode());

    return $response;
});

$app->get('/api/categories', function ($request, ResponseInterface $response, $args) {
    $ctrlResponse = $this->get('CategoryController')->getAllCategories();
    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($ctrlResponse->data(), $ctrlResponse->httpCode());

    return $response;
});

$app->get('/api/users/restaurants', function ($request, ResponseInterface $response, $args) {
    $ctrlResponse = $this->get('UserController')->getRestaurantsOfUser($request);
    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($ctrlResponse->data(), $ctrlResponse->httpCode());

    return $response;
});
