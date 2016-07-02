<?php

namespace Tests\Application\Controllers;

use Gogordos\Application\Controllers\UsersController;
use Gogordos\Application\StatusCode;
use Gogordos\Application\UseCases\RegisterUserResponse;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Slim\Http\Request;

class UsersControllerTest extends TestCase
{
    /** @var UsersController */
    private $sut;

    /** @var RegisterUserUseCase */
    private $registerUserUseCase;

    protected function setUp()
    {
        $this->registerUserUseCase = $this->prophesize(RegisterUserUseCase::class);

        $this->sut = new UsersController(
            $this->registerUserUseCase->reveal()
        );
    }

    public function test_when_valid_params_are_provided_user_can_register_successfully()
    {
        $requestMock = $this->prophesize(Request::class);
        $requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new RegisterUserResponse('success', null));

        $json = $this->sut->register($requestMock->reveal());

        $this->assertEquals(['status' => StatusCode::STATUS_SUCCESS], $json);
    }
}
