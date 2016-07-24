<?php

namespace Gogordos\Framework\Repositories;


use Gogordos\Domain\Entities\Friend;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\FriendRepository;
use PDO;
use PDOStatement;
use Ramsey\Uuid\Uuid;

class FriendRepositoryMysql extends BaseRepository implements FriendRepository
{
    public function save(Friend $friendship)
    {
        if (empty($friendship->userIdFollower()) || empty($friendship->userIdFollowing())) {
            throw new \Exception('Impossible to save friend. A field is missing');
        }

        $userIdFollower = $friendship->userIdFollower()->value();
        $userIdFollowing = $friendship->userIdFollowing()->value();
        $createdAt = date('Y-m-d H:i:s');

        /** @var PDO $pdo */
        $pdo = $this->getConnection();
        /** @var PDOStatement $statement */
        $statement = $pdo->prepare('INSERT INTO friends (user_id_follower, user_id_following, created_at) VALUES (?, ?, ?)');
        $statement->bindParam(1, $userIdFollower, PDO::PARAM_STR);
        $statement->bindParam(2, $userIdFollowing, PDO::PARAM_STR);
        $statement->bindParam(3, $createdAt, PDO::PARAM_STR);

        $result = $statement->execute();

        if (!$result) {
            throw new \Exception('Error creating a new friend');
        }
        return new Friend(
            new UserId(Uuid::fromString($userIdFollower)),
            new UserId(Uuid::fromString($userIdFollowing)),
            $createdAt
        );
    }

    public function exists(Friend $friend)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM friends WHERE user_id_follower = :user_id_follower AND user_id_following = :user_id_following');

        $statement->execute([
            ':user_id_follower' => $friend->userIdFollower()->value(),
            ':user_id_following' => $friend->userIdFollowing()->value()
        ]);
        $row = $statement->fetch(PDO::FETCH_OBJ);

        if ($row === false) {
            return false;
        }

        return true;
    }
}
