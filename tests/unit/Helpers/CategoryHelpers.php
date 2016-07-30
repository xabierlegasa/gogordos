<?php

namespace Tests\Helpers;


use Gogordos\Domain\Entities\Category;

trait CategoryHelpers
{
    public function buildCategory()
    {
        return new Category(1, 'italian', 'Italiano');
    }
}
