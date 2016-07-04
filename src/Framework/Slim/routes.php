<?php

use Gogordos\Application\Controllers\UsersController;
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


//$app->get('/SignUp', function ($request, $response, $args) {
//    return $this->renderer->render($response, 'signup.phtml', ["router" => $this->router]);
//})->setName('signUp');


$app->post('/api/users', function ($request, ResponseInterface $response, $args) {
    $usersController = new UsersController($this->get('RegisterUserUseCase'));
    $data = $usersController->register($request);

    $response = $response
        ->withHeader('Content-Type', 'application/json')
        ->withJson($data, 200);

    return $response;
})->setName('signUp');
