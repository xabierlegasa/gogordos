<?php

namespace Tests\Application\UseCases;

use Gogordos\Application\Exceptions\EmailAlreadyExistsException;
use Gogordos\Application\UseCases\RegisterUserRequest;
use Gogordos\Application\UseCases\RegisterUserResponse;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\UsersRepository;
use Gogordos\Domain\Services\Authenticator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class RegisterUserUseCaseTest extends TestCase
{
    /** @var RegisterUserUseCase */
    private $sut;

    /** @var UsersRepository */
    private $usersRepository;

    /** @var Authenticator */
    private $authenticator;

    protected function setUp()
    {
        $this->usersRepository = $this->prophesize(UsersRepository::class);
        $this->authenticator = $this->prophesize(Authenticator::class);

        $this->sut = new RegisterUserUseCase(
            $this->usersRepository->reveal(),
            $this->authenticator->reveal()
        );
    }

    public function test_when_user_with_same_email_exists_should_throw_an_exception()
    {
        $this->expectException(EmailAlreadyExistsException::class);

        $email = 'hello@example.com';
        $username = 'username';
        $existingUser = User::register(new UserId(Uuid::uuid4()), $email, 'a_different_username', 'password');

        $this->usersRepository->findByEmailOrUsername($email, $username)
            ->shouldBeCalled()
            ->willReturn($existingUser);

        $this->sut->execute(new RegisterUserRequest($email, $username, 'password'));
    }

    public function test_when_user_email_is_invalid_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->sut->execute(new RegisterUserRequest('username', 'invalidEmail@', 'password'));
    }

    public function test_when_username_is_too_long_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $username = 'username_is_too_looooooooooooooooooong';

        $this->sut->execute(new RegisterUserRequest($username, 'hello@example.com', 'password'));
    }

    public function test_when_username_has_a_blank_shout_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $username = 'username hasABlank';

        $this->sut->execute(new RegisterUserRequest($username, 'hello@example.com', 'password'));
    }

    public function test_when_password_has_less_than_four_characters_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->sut->execute(new RegisterUserRequest('username', 'hello@example.com', 'xxx'));
    }

    public function test_when_user_does_not_exists_and_input_data_is_valid_create_user()
    {
        $username = 'username';
        $email = 'hello@example.com';
        $password = 'password';
        $jwt = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiSm9obiBEb2UiLCJhZG1pbiI6dHJ1ZX0.OLvs36KmqB9cmsUrMpUutfhV52_iSz4bQMYJjkI_TLQ';

        $this->usersRepository->findByEmailOrUsername($email, $username)
            ->shouldBeCalled()
            ->willReturn(null);

        $user = User::register(new UserId(Uuid::uuid4()), $email, $username, $password);

        $this->authenticator->createJWTForUser(Argument::type(User::class))
            ->shouldBeCalled()
            ->willReturn($jwt);

        $this->usersRepository->save(Argument::type(User::class))
            ->shouldBeCalled()
            ->willReturn($user);

        /** @var RegisterUserResponse $response */
        $response = $this->sut->execute(new RegisterUserRequest($email, $username, $password));

        $this->assertEquals('success', $response->code());
        $this->assertEquals($jwt, $response->jwt());
    }
}
