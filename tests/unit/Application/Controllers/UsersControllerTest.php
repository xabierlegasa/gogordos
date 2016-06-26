<?php

namespace Tests\Application\Controllers;

use Gogordos\Application\Controllers\UsersController;
use League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;

class UsersControllerTest extends TestCase
{
    /** @var UsersController */
    private $sut;

    /** @var CommandBus */
    private $commandBusMock;

    protected function setUp()
    {
        $this->commandBusMock = $this->prophesize(CommandBus::class);
        $this->sut = new UsersController(
            $this->commandBusMock->reveal()
        );
    }


    public function test_when_valid_params_are_provided_user_can_register_successfully()
    {
        $json = $this->sut->register(null);

        $this->assertEquals('{"response_code":"ok"}', $json);
    }
}