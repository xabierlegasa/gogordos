<?php

namespace Gogordos\framework\Repositories;


use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Repositories\UsersRepository;
use PDO;

class UsersRepositoryMysql implements UsersRepository
{
    public function save(User $user)
    {
        $connection = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'root');

        $statement = $connection->prepare('INSERT INTO users VALUES (1, "somevalue"');
        $affectedRows = $connection->execute([
            ':name' => $name
        ]);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        // TODO: Implement findByEmail() method.
    }
}