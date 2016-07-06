<?php

namespace Tests\Application\UseCases;


use Gogordos\Application\UseCases\AuthenticateRequest;
use Gogordos\Application\UseCases\AuthenticateUseCase;
use Gogordos\Domain\Services\Authenticator;
use PHPUnit\Framework\TestCase;

class AuthenticateUseCaseTest extends TestCase
{
    /** @var AuthenticateUseCase */
    private $sut;

    /** @var AuthenticateRequest */
    private $authenticateRequestMock;

    /** @var Authenticator */
    private $authenticator;

    public function setUp()
    {
        $this->authenticator = $this->prophesize(Authenticator::class);
        $this->authenticateRequestMock = $this->prophesize(AuthenticateRequest::class);
        $this->sut = new AuthenticateUseCase(
            $this->authenticator->reveal()
        );
    }
    
    public function test_when_jwt_parameter_is_empty_an_exception_is_thrown()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sut->execute(new AuthenticateRequest(null));
    }

    public function test_when_jwt_parameter_is_invalid_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->authenticator->userFromToken('invalid_jwt_parameter')
            ->shouldBeCalled()
            ->willThrow(new \InvalidArgumentException('Error validating logged in user'));

        $this->sut->execute(new AuthenticateRequest('invalid_jwt_parameter'));
    }
}
