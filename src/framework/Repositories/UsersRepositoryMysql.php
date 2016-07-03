<?php

namespace Gogordos\framework\Repositories;


use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\UsersRepository;
use PDO;
use PDOStatement;
use Ramsey\Uuid\Uuid;


/**
 * Implementation done via PDO.
 * Class UsersRepositoryMysql
 * @package Gogordos\framework\Repositories
 */
class UsersRepositoryMysql implements UsersRepository
{
    /**
     * Insert a user in the DB. Returns true if successful, or false otherwise
     * @param User $user
     * @return bool
     */
    public function save(User $user)
    {
        $userId = $user->id();
        $email = $user->email();
        $username = $user->username();;
        $passwordHash = $user->password();

        $connection = $this->getConnection();

        /** @var PDOStatement $statement */
        $statement = $connection->prepare('INSERT INTO users (id, email, username, password_hash) VALUES (?, ?, ?, ?)');
        $statement->bindParam(1, $userId, PDO::PARAM_STR);
        $statement->bindParam(2, $email, PDO::PARAM_STR);
        $statement->bindParam(3, $username, PDO::PARAM_STR);
        $statement->bindParam(4, $passwordHash, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email)
    {
        $connection = $this->getConnection();
        /** @var PDOStatement $statement */
        $statement = $connection->prepare('SELECT * FROM users WHERE email = :email');

        $statement->execute([
            ':email' => $email
        ]);
        $row = $statement->fetch(PDO::FETCH_OBJ);

        if ($row === false) {
            return null;
        }

        /** User was found */
        return User::register(
            UserId::fromString($row->id),
            $row->email,
            $row->username,
            $row->password_hash
        );
    }

    private function getConnection()
    {
        // TODO REMOVE CREDENTIALS FROM HERE!
        // See PDO prepared statements
        $connection = new PDO('mysql:host=localhost;dbname=gogordos;charset=utf8', 'root', 'root');

        return $connection;
    }
}
