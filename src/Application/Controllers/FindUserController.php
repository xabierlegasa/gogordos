<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Domain\Repositories\UsersRepository;
use Slim\Http\Request;

class FindUserController
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * FindUserController constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function findUsersByTerm(Request $request)
    {
        try {
            $terms = $request->getParam('terms');
            if (strlen($terms) < 3) {
                throw new \InvalidArgumentException('Terms must be 4 chars or more');
            }
            $users = $this->usersRepository->findUsersWithUsernameSimilarTo($terms);

            $usersPresented = [];
            foreach ($users as $user) {
                $usersPresented[] = [
                  'username' => $user->username()
                ];
            }

            return new JsonOk([
                'users' => $usersPresented
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest([
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return new JsonBadRequest([
                'users' => []
            ]);
        }
    }
}
