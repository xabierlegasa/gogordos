<?php

namespace Gogordos\framework\Repositories;


use Gogordos\domain\entities\User;
use Gogordos\domain\repositories\UsersRepository;
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
}