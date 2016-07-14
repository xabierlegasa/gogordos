<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\Category;
use Gogordos\Domain\Repositories\CategoryRepository;
use PDO;
use PDOStatement;

class CategoryRepositoryMysql extends BaseRepository implements CategoryRepository
{
    /**
     * @param $name
     * @return Category
     */
    public function findByName($name)
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM category WHERE name = :name');

        $statement->execute([
            ':name' => $name
        ]);
        $row = $statement->fetch(PDO::FETCH_OBJ);

        if ($row === false) {
            return null;
        }

        /** User was found */
        return new Category(
            $row->id,
            $row->name,
            $row->name_es
        );
    }

    public function findAll()
    {
        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('SELECT * FROM category');

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);
        
        if ($rows === false) {
            return null;
        }

        $categories = [];
        foreach ($rows as $row) {
            $categories[] = new Category(
                $row->id,
                $row->name,
                $row->name_es
            );
        }
        
        return $categories;
    }
}
