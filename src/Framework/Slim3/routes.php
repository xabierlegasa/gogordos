<?php

use Gogordos\Application\Controllers\UsersController;
use Psr\Http\Message\ResponseInterface;

// Routes

//$app->get('/[{name}]', function ($request, $response, $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});


$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->view->render($response, 'default/welcome.html.twig', [
        'foo' => 'bar'
    ]);
});

$app->get('/SignUp', function ($request, $response, $args) {
    return $this->view->render($response, 'default/signUp.html.twig', []);
})->setName('signUp');

$app->post('/SignUp', function ($request, ResponseInterface $response, $args) {
    $usersController = new UsersController($this->get('RegisterUserUseCase'));
    $data = $usersController->register($request);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->withJson($data, 200);

    return $response;
})->setName('signUp');



$app->post('/api/users', function ($request, $response, $args) {


});


