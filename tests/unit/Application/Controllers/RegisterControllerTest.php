<?php

namespace Tests\Application\Controllers;

use Gogordos\Application\Controllers\RegisterController;
use Gogordos\Application\Exceptions\EmailAlreadyExistsException;
use Gogordos\Application\StatusCode;
use Gogordos\Application\UseCases\RegisterUserResponse;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;

class RegisterControllerTest extends TestCase
{
    /** @var RegisterController */
    private $sut;

    /** @var RegisterUserUseCase */
    private $registerUserUseCase;

    /** @var Request */
    private $requestMock;

    protected function setUp()
    {
        $this->registerUserUseCase = $this->prophesize(RegisterUserUseCase::class);
        $this->requestMock = $this->prophesize(Request::class);

        $this->sut = new RegisterController(
            $this->registerUserUseCase->reveal()
        );
    }

    public function test_when_valid_params_are_provided_user_can_register_successfully()
    {
        $this->requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $this->requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $this->requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');
        $userMock = $this->prophesize(User::class);

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willReturn(
                new RegisterUserResponse(
                    StatusCode::STATUS_SUCCESS,
                    $userMock->reveal(),
                    'headerB64.payloadB64.signatureB64'
                )
            );

        $data = $this->sut->register($this->requestMock->reveal());
        
        $this->assertEquals(StatusCode::STATUS_SUCCESS, $data['status']);
        $this->assertEquals('headerB64.payloadB64.signatureB64', $data['jwt']);
    }

    public function test_when_user_whith_provided_email_already_exists_should_return_correct_error_response()
    {
        $this->requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $this->requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $this->requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new EmailAlreadyExistsException('Exception message here'));
        $json = $this->sut->register($this->requestMock->reveal());

        $this->assertEquals(['status' => StatusCode::STATUS_ERROR, 'message' => 'Exception message here'], $json);
    }

    public function test_when_infrastructure_throws_an_exception_controller_should_return_correct_error_response()
    {
        $this->requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $this->requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $this->requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new \Exception('Exception message'));
        $json = $this->sut->register($this->requestMock->reveal());

        $this->assertEquals(['status' => StatusCode::STATUS_ERROR, 'message' => 'Yuuups something went wrong. Message:' . 'Exception message'], $json);
    }
}
