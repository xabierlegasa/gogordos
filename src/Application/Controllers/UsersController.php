<?php

namespace Gogordos\Application\Controllers;


class UsersController
{
    /** @var RegisterUserUseCase */
    private $registerUserUseCase;
    
    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

//    /**
//     * Example action for calling dummy command!
//     * @param $request
//     * @return string
//     */
//    public function dummy($request)
//    {
//        /** @var DummyResponse $commandResponse */
//        $commandResponse = $this->bus->handle(
//            new DummyCommand('xabi', 'xabi@vreasy.com', '123456789')
//        );
//        exit;
//    }

    public function register($request)
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $registerUserRequest = new RegisterUserRequest($username, $email, $password);
        $response = $this->registerUserUseCase->execute($registerUserRequest);

        $json = json_encode(['response_code' => $response->code()]);

        return $json;
    }
}