<?php

namespace Gogordos\Application\Presenters;


use Gogordos\Domain\Entities\Restaurant;

class RestaurantPresenter
{
    /**
     * @param array $restaurants
     * @return array
     */
    public function presentRestaurantsWithUserData($restaurants)
    {
        $items = [];

        /** @var Restaurant $restaurant */
        foreach ($restaurants as $restaurant) {
            $item = [
                'name' => $restaurant->name(),
                'city' => $restaurant->city(),
                'categoryId' => $restaurant->category()->id(),
                'categoryName' => $restaurant->category()->name(),
                'categoryNameEs' => $restaurant->category()->nameEs(),
                'username' => $restaurant->user()->username()
            ];
            $items[] = $item;
        }

        return $items;
    }
}