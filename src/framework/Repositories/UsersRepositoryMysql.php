<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\UsersRepository;
use PDO;
use PDOStatement;

class UsersRepositoryMysql extends BaseRepository implements UsersRepository
{
    /**
     * Insert a user in the DB. Returns true if successful, or false otherwise
     * @param User $user
     * @return bool
     */
    public function save(User $user)
    {
        $userId = $user->id()->value();
        $email = $user->email();
        $username = $user->username();;
        $passwordHash = $user->password();
        $createdAt = date('Y-m-d H:i:s');

        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('INSERT INTO users (id, email, username, password_hash, created_at) VALUES (?, ?, ?, ?, ?)');
        $statement->bindParam(1, $userId, PDO::PARAM_STR);
        $statement->bindParam(2, $email, PDO::PARAM_STR);
        $statement->bindParam(3, $username, PDO::PARAM_STR);
        $statement->bindParam(4, $passwordHash, PDO::PARAM_STR);
        $statement->bindParam(5, $createdAt, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM users WHERE email = :email');

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

    /**
     * @param string $email
     * @param string $username
     * @return User|null
     */
    public function findByEmailOrUsername($email, $username)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM users WHERE email = :email OR username = :username');

        $statement->execute([
            ':email' => $email,
            ':username' => $username
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

    /**
     * @param string $usernameOrEmail
     * @return User|null
     */
    public function findByEmailOrUsernameSingleParameter($usernameOrEmail)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM users WHERE email = :usernameOrEmail OR username = :usernameOrEmail');

        $statement->execute([
            ':usernameOrEmail' => $usernameOrEmail
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

    /**
     * @param $username
     * @return User|null
     */
    public function findByUsername($username)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM users WHERE username = :username');

        $statement->execute([
            ':username' => $username
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

    /**
     * @param string $term
     * @return User[]|null
     */
    public function findUsersWithUsernameSimilarTo($term)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM users WHERE username LIKE :term');

        $statement->execute([
            ':term' => '%' . $term . '%'
        ]);
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        if ($rows === false) {
            return [];
        }

        $users = [];
        foreach ($rows as $row) {
            $users[] = User::register(
                UserId::fromString($row->id),
                $row->email,
                $row->username,
                $row->password_hash
            );
        }

        return $users;
    }
}
