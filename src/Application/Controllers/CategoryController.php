<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Domain\Repositories\CategoryRepository;

class CategoryController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoriesController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    public function getAllCategories()
    {
        $categories = $this->categoryRepository->findAll();
        return new JsonOk(
            [
                'categories' => $categories
            ]
        );
    }
}
