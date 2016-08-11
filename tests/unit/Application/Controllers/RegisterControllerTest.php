<?php

namespace Tests\Application\Controllers;

use Gogordos\Application\Controllers\RegisterController;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Controllers\Response\JsonResponse;
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
                    $userMock->reveal(),
                    'headerB64.payloadB64.signatureB64'
                )
            );

        /** @var JsonOk $jsonOk */
        $jsonOk = $this->sut->register($this->requestMock->reveal());
        $this->assertEquals(200, $jsonOk->httpCode());
        $data = $jsonOk->data();
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
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->sut->register($this->requestMock->reveal());
        $this->assertEquals(400, $jsonResponse->httpCode());
        $this->assertEquals(['status' => StatusCode::STATUS_ERROR, 'errorMessage' => 'Exception message here'], $jsonResponse->data());
    }

    public function test_when_infrastructure_throws_an_exception_controller_should_return_correct_error_response()
    {
        $this->requestMock->getParam("username")->shouldBeCalled()->willReturn('xabierlegasa');
        $this->requestMock->getParam('email')->shouldBeCalled()->willReturn('xabierlegasa@gmail.com');
        $this->requestMock->getParam('password')->shouldBeCalled()->willReturn('1111');

        $this->registerUserUseCase->execute(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new \Exception('Exception message'));

        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->sut->register($this->requestMock->reveal());
        $data = $jsonResponse->data();
        $this->assertEquals(500, $jsonResponse->httpCode());
        $this->assertEquals(
            [
                'status' => StatusCode::STATUS_ERROR,
                'errorMessage' => 'Yuuups something went wrong. Message:Exception message'
            ],
            $data
        );
    }
}
