<?php

namespace Gogordos\Application\UseCases;

use Gogordos\Application\Exceptions\EmailAlreadyExistsException;
use Gogordos\Application\Exceptions\UsernameAlreadyExistsException;
use Gogordos\Application\StatusCode;
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

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param RegisterUserRequest $request
     * @return RegisterUserResponse
     */
    public function execute(RegisterUserRequest $request)
    {
        $this->checkInputDataIsValid($request);

        $this->checkUserDoesNotExist($request);

        $user = User::register(
            new UserId(Uuid::uuid4()),
            $request->email(),
            $request->username(),
            $request->password()
        );

        if ($this->usersRepository->save($user)) {
            return new RegisterUserResponse(
                StatusCode::STATUS_SUCCESS,
                $user
            );
        } else {
            return new RegisterUserResponse(
                StatusCode::STATUS_ERROR,
                null
            );
        }
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
     * @param RegisterUserRequest $request
     * @throws EmailAlreadyExistsException
     * @throws UsernameAlreadyExistsException
     */
    private function checkUserDoesNotExist(RegisterUserRequest $request)
    {
        $user = $this->usersRepository->findByEmailOrUsername($request->email(), $request->username());

        if ($user) {
            if ($user->email() === $request->email()) {
                throw new EmailAlreadyExistsException('A user with that email already exists');
            }
            
            throw new UsernameAlreadyExistsException('A user with that username already exists');
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
     * @param RegisterUserRequest $request
     */
    private function checkInputDataIsValid(RegisterUserRequest $request)
    {
        $this->checkEmailIsValid($request->email());
        $this->checkUsernameIsValid($request->username());
        $this->checkPasswordIsValid($request->password());
    }
}
