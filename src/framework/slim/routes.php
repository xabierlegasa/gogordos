<?php

use Gogordos\Application\Controllers\UsersController;




// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->post('/api/users', function ($request, $response, $args) {

    $usersController = new UsersController($this->get('bus'));
    $json = $usersController->register($request);

    header("Content-Type: application/json");
    echo $json;
    exit;
});


