<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonInternalServerError;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Domain\Entities\Friend;
use Gogordos\Domain\Repositories\FriendRepository;
use Gogordos\Domain\Repositories\UsersRepository;
use Gogordos\Domain\Services\Authenticator;
use Slim\Http\Request;

class AddFriendController
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var FriendRepository
     */
    private $friendRepository;
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * AddFriendController constructor.
     * @param UsersRepository $usersRepository
     * @param FriendRepository $friendRepository
     * @param Authenticator $authenticator
     */
    public function __construct(
        UsersRepository $usersRepository,
        FriendRepository $friendRepository,
        Authenticator $authenticator
    ) {
        $this->usersRepository = $usersRepository;
        $this->friendRepository = $friendRepository;
        $this->authenticator = $authenticator;
    }

    public function addFriend(Request $request)
    {
        try {
            $username = $request->getParam('username');
            $user = $this->usersRepository->findByUsername($username);

            if (empty($user)) {
                throw new \InvalidArgumentException('El usuario no existe');
            }

            $token = $request->getParam('jwt');
            /** @var AuthUserData $authUserData */
            $authUserData = $this->authenticator->authUserDataFromToken($token);
            if ($user->id()->value() === $authUserData->userId()->value()) {
                throw new \InvalidArgumentException('No te puedes añadir a ti mismo como amigo');
            }
            $friend = new Friend(
                $authUserData->userId(),
                $user->id()
            );

            if ($this->friendRepository->exists($friend)) {
                throw new \InvalidArgumentException('Ya eres amigo de esa persona.');
            }

            $friend = $this->friendRepository->save($friend);

            return new JsonOk([
                'friend_username' => $username
            ]);

        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return new JsonInternalServerError(['message' => $e->getMessage()]);
        }
    }
}
