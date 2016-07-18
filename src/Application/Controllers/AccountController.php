<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\StatusCode;
use Gogordos\Application\UseCases\AuthenticateRequest;
use Gogordos\Application\UseCases\AuthenticateUseCase;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Repositories\UsersRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class AccountController
{
    /**
     * @var AuthenticateUseCase
     */
    private $authenticateUseCase;
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * AccountController constructor.
     * @param AuthenticateUseCase $authenticateUseCase
     * @param UsersRepository $usersRepository
     */
    public function __construct(AuthenticateUseCase $authenticateUseCase, UsersRepository $usersRepository)
    {
        $this->authenticateUseCase = $authenticateUseCase;
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAccount(Request $request)
    {
        try {
            $jwt = $request->getParam('jwt');
            $res = $this->authenticateUseCase->execute(new AuthenticateRequest($jwt));
            $authUserData = $res->authUserData();
            $username = $authUserData->username();

            /** @var User $user */
            $user = $this->usersRepository->findByUsername($username);

            return new JsonOk(
                [
                    'user' => [
                        'username' => $user->username(),
                        'email' => $user->email()
                    ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonBadRequest(
                [
                    'messages' => $e->getMessage()
                ]
            );
        }
    }
}