<?php

use Gogordos\Application\Controllers\UsersController;
use Psr\Http\Message\ResponseInterface;

// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->renderer->render($response, 'index.html', [
        "router" => $this->router
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
