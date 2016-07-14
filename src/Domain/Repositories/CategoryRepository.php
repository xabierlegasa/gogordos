<?php

namespace Gogordos\Domain\Repositories;


use Gogordos\Domain\Entities\Category;

interface CategoryRepository
{
    /**
     * @param $name
     * @return Category
     */
    public function findByName($name);
}