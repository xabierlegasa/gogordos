<?php

namespace Gogordos\Application\UseCases;

class RegisterUserUseCase
{
    public function execute(RegisterUserRequest $registerUserRequest)
    {
        return new RegisterUserResponse('success');
    }
}