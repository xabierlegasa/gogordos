<?php

namespace Tests\Application\Services;

use Gogordos\Application\Services\JwtAuthenticator;
use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Services\Authenticator;
use Lcobucci\JWT\Builder;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class JwtAuthenticatorTest extends TestCase
{
    /** @var Authenticator */
    private $sut;

    /** @var Logger */
    private $logger;

    public function setUp()
    {
        $this->logger = $this->prophesize(Logger::class);

        $this->sut = new JwtAuthenticator(
            new Builder(),
            $this->logger->reveal()
        );
    }
    
    public function test_when_we_provide_a_valid_token_should_return_an_authUserData_with_users_data()
    {
        $user = User::register(
            new UserId(Uuid::fromString('46e7faad-c4db-4a6f-9f01-fe9d9322d238')),
            'hello@example.com',
            'username',
            'password'
        );

        $jwtToken = $this->sut->authTokenFromUser($user);
        $this->assertEquals(472, strlen($jwtToken));

        /** @var AuthUserData $authUserData */
        $authUserData = $this->sut->authUserDataFromToken($jwtToken);

        $this->assertInstanceOf(AuthUserData::class, $authUserData);
        $this->assertEquals('username', $authUserData->username());
    }

    public function test_when_token_is_invalid_should_log_the_error_and_throw_correct_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->logger->error('Error trying to get authUserData from a token', Argument::any())
            ->shouldBeCalled();
        /** @var AuthUserData $authUserData */
        $this->sut->authUserDataFromToken('this_is .$an_invalid token');
    }
}
