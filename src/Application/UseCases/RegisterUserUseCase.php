<?php

namespace Gogordos\Application\UseCases;

use Gogordos\Application\Exceptions\UserAlreadyExistsException;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator;

class RegisterUserUseCase
{
    const USERNAME_LENGTH_MIN = 3;
    const USERNAME_LENGTH_MAX = 25;
    const PASSWORD_LENGTH_MIN = 4;
    const PASSWORD_LENGTH_MAX = 250;

    /** @var  UsersRepository */
    private $usersRepository;

    /** @var Validator */
    private $validator;

    public function __construct(UsersRepository $usersRepository, $validator)
    {
        $this->usersRepository = $usersRepository;
        $this->validator = $validator;
    }

    /**
     * @param RegisterUserRequest $request
     * @return RegisterUserResponse
     */
    public function execute(RegisterUserRequest $request)
    {
        $this->checkInputDataIsValid($request);

        $user = User::register(
            new UserId(Uuid::uuid4()),
            $request->email(),
            $request->username(),
            $request->password()
        );

        $this->usersRepository->save($user);

        return new RegisterUserResponse('success');
    }

    /**
     * @param $email
     * @throws \InvalidArgumentException
     */
    private function checkEmailIsValid($email)
    {
        /** Check email is valid */
        /** @var Validator $emailValidator */
        $emailValidator = Validator::email();
        if (!$emailValidator->validate($email)) {
            throw new \InvalidArgumentException('Invalid email');
        }
    }

    /**
     * @param string $email
     * @throws UserAlreadyExistsException
     */
    private function checkUserDoesNotExist($email)
    {
        $user = $this->usersRepository->findByEmail($email);
        if ($user) {
            throw new UserAlreadyExistsException('User already exists');
        }
    }

    /**
     * @param $username
     * @throws \InvalidArgumentException
     */
    private function checkUsernameIsValid($username)
    {
        $usernameValidator = Validator::stringType()
            ->alnum('_')
            ->noWhitespace()
            ->length(
                static::USERNAME_LENGTH_MIN,
                static::USERNAME_LENGTH_MAX
            );

        if (!$usernameValidator->validate($username)) {
            throw new \InvalidArgumentException(
                'Invalid username. Must be between ' .
                static::USERNAME_LENGTH_MIN . ' and ' . static::USERNAME_LENGTH_MAX .
                ' characters long'
            );
        }
    }

    private function checkPasswordIsValid($password)
    {
        $passwordValidator = Validator::stringType()
            ->noWhitespace()
            ->length(
                static::PASSWORD_LENGTH_MIN,
                static::PASSWORD_LENGTH_MAX
            );

        if (!$passwordValidator->validate($password)) {
            throw new \InvalidArgumentException(
                'Invalid password. Must be between ' .
                static::PASSWORD_LENGTH_MIN . ' and ' . static::PASSWORD_LENGTH_MAX .
                ' characters long'
            );
        }
    }

    /**
     * @param RegisterUserRequest $registerUserRequest
     */
    private function checkInputDataIsValid(RegisterUserRequest $registerUserRequest)
    {
        $this->checkEmailIsValid($registerUserRequest->email());
        $this->checkUsernameIsValid($registerUserRequest->username());
        $this->checkPasswordIsValid($registerUserRequest->password());
        $this->checkUserDoesNotExist($registerUserRequest->email());
    }
}
