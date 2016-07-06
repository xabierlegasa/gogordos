<?php

namespace Tests\Application\Controllers;

use Gogordos\Application\Controllers\AuthenticationController;
use Gogordos\Application\StatusCode;
use Gogordos\Application\UseCases\AuthenticateRequest;
use Gogordos\Application\UseCases\AuthenticateResponse;
use Gogordos\Application\UseCases\AuthenticateUseCase;
use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Services\Authenticator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;

class AuthenticationControllerTest extends TestCase
{
    /** @var AuthenticationController */
    private $sut;

    /** @var Request */
    private $requestMock;

    /** @var AuthenticateUseCase */
    private $authenticateUserCase;

    protected function setUp()
    {
        $this->authenticateUserCase = $this->prophesize(AuthenticateUseCase::class);
        $this->requestMock = $this->prophesize(Request::class);
        $this->sut = new AuthenticationController(
            $this->authenticateUserCase->reveal()
        );
    }

    public function test_when_no_jwt_is_given_should_return_correct_error_response()
    {
        $this->requestMock->getParam('jwt')
            ->shouldBeCalled()
            ->willReturn(null);

        $this->authenticateUserCase->execute(new AuthenticateRequest(null))
            ->shouldBeCalled()
            ->willThrow(new \InvalidArgumentException('Authorization token (jwt) is missing'));

        $data = $this->sut->authenticate($this->requestMock->reveal());

        $this->assertEquals(StatusCode::STATUS_ERROR, $data['status']);
        $this->assertEquals('Authorization token (jwt) is missing', $data['message']);
    }

    public function test_when_an_invalid_jwt_token_is_given_should_return_correct_error_response()
    {
        $this->requestMock->getParam('jwt')
            ->shouldBeCalled()
            ->willReturn('invalid_jwt_param');
        $this->authenticateUserCase->execute(new AuthenticateRequest('invalid_jwt_param'))
            ->shouldBeCalled()
            ->willThrow(new \InvalidArgumentException('Authorization token (jwt) is invalid'));

        $data = $this->sut->authenticate($this->requestMock->reveal());

        $this->assertEquals(StatusCode::STATUS_ERROR, $data['status']);
        $this->assertEquals('Authorization token (jwt) is invalid', $data['message']);
    }

    public function test_when_a_valid_jwt_token_is_given_should_return_correct_user_data()
    {
        $this->requestMock->getParam('jwt')
            ->shouldBeCalled()
            ->willReturn('valid_jwt_token');

        $authUserData = new AuthUserData(new UserId(Uuid::uuid4()), 'username');
        $this->authenticateUserCase->execute(new AuthenticateRequest('valid_jwt_token'))
            ->shouldBeCalled()
            ->willReturn(new AuthenticateResponse($authUserData));

        $data = $this->sut->authenticate($this->requestMock->reveal());
        $this->assertEquals(StatusCode::STATUS_SUCCESS, $data['status']);
        $this->assertEquals('username', $data['user']['username']);
    }
}
