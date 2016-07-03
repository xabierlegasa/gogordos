<?php

use Gogordos\Application\Commands\DummyCommand;
use Gogordos\Application\Commands\DummyHandle;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

$container = $app->getContainer();


// command bus
$container['bus'] = function ($c) {

    $locator = new InMemoryLocator([]);
    $locator->addHandler(
        new DummyHandle(),
        DummyCommand::class
    );

    $handlerMiddleware = new CommandHandlerMiddleware(
        new ClassNameExtractor,
        $locator,
        new HandleInflector
    );
    $bus = new CommandBus([$handlerMiddleware]);

    return $bus;
};
