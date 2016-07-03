<?php

namespace Tests\Application\Controllers;

use Gogordos\Application\Controllers\UsersController;
use Gogordos\Application\Exceptions\EmailAlreadyExistsException;
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
            ->willReturn(new RegisterUserResponse(StatusCode::STATUS_SUCCESS, null));

        $json = $this->sut->register($requestMock->reveal());

        $this->assertEquals(['status' => StatusCode::STATUS_SUCCESS], $json);
    }

    public function test_when_user_whith_provided_email_already_exists_should_return_correct_error_response()
    {
        $requestMock = $this->prophesize(Request::class);
        $requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new EmailAlreadyExistsException('Exception message here'));
        $json = $this->sut->register($requestMock->reveal());

        $this->assertEquals(['status' => StatusCode::STATUS_ERROR, 'message' => 'Exception message here'], $json);
    }

    public function test_when_infrastructure_throws_an_exception_controller_should_return_correct_error_response()
    {
        $requestMock = $this->prophesize(Request::class);
        $requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new \Exception('Exception message'));
        $json = $this->sut->register($requestMock->reveal());

        $this->assertEquals(['status' => StatusCode::STATUS_ERROR, 'message' => 'Yuuups something went wrong. Message:' . 'Exception message'], $json);
    }
}
