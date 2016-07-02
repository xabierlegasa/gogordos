<?php

namespace Tests\Application\UserCases;

use Gogordos\Application\Exceptions\UserAlreadyExistsException;
use Gogordos\Application\UseCases\RegisterUserRequest;
use Gogordos\Application\UseCases\RegisterUserResponse;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\UsersRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator;

class RegisterUserUseCaseTest extends TestCase
{
    /** @var RegisterUserUseCase */
    private $sut;

    /** @var UsersRepository */
    private $usersRepository;

    /** @var Validator */
    private $validator;

    protected function setUp()
    {
        $this->usersRepository = $this->prophesize(UsersRepository::class);
        $this->validator = $this->prophesize(Validator::class);

        $this->sut = new RegisterUserUseCase(
            $this->usersRepository->reveal(),
            $this->validator->reveal()
        );
    }

    public function test_when_user_already_exists_should_throw_an_exception()
    {
        $this->expectException(UserAlreadyExistsException::class);

        $email = 'hello@example.com';
        $username = 'username';
        $existingUser = User::register(new UserId(Uuid::uuid4()), $email, $username, 'password');

        $this->usersRepository->findByEmail($email)
            ->shouldBeCalled()
            ->willReturn($existingUser);

        $this->sut->execute(new RegisterUserRequest($username, $email, 'password'));
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

        $this->usersRepository->findByEmail($email)
            ->shouldBeCalled()
            ->willReturn(null);

        $user = User::register(new UserId(Uuid::uuid4()), $email, $username, $password);
        
        $this->usersRepository->save(Argument::type(User::class))
            ->shouldBeCalled()
            ->willReturn($user);

        /** @var RegisterUserResponse $response */
        $response = $this->sut->execute(new RegisterUserRequest($username, $email, $password));

        $this->assertEquals('success', $response->code());
    }
}
