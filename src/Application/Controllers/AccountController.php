<?php

namespace Gogordos\Application\Controllers;


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
     * @param Response $response
     * @return Response
     */
    public function getAccount(Request $request, Response $response)
    {
        try {
            $jwt = $request->getParam('jwt');
            $res = $this->authenticateUseCase->execute(new AuthenticateRequest($jwt));
            $authUserData = $res->authUserData();
            $username = $authUserData->username();
            
            /** @var User $user */
            $user = $this->usersRepository->findByUsername($username);
            $data = [
                'user' => [
                    'username' => $user->username(),
                    'email' => $user->email()
                ]
            ];

            $response = $response
                ->withHeader('Content-Type', 'application/json')
                ->withJson($data, 200);

            return $response;
        } catch (\Exception $e) {
            $data = [
                'status' => StatusCode::STATUS_ERROR,
                'errorMessage' => $e->getMessage()
            ];
            $response = $response
                ->withHeader('Content-Type', 'application/json')
                ->withJson($data, 500);

            return $response;
        }
    }
}