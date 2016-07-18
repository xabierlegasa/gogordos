<?php

namespace Tests\Application\UseCases\AddRestaurant;

use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantRequest;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantUseCase;
use Gogordos\Domain\Entities\Category;
use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\CategoryRepository;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Services\Authenticator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class AddRestaurantUseCaseTest extends TestCase
{
    /** @var AddRestaurantUseCase */
    private $sut;

    /** @var CategoryRepository  */
    private $categoryRepositoryMock;

    /** @var RestaurantRepository */
    private $restaurantRepositoryMock;

    /**
     * @var Authenticator
     */
    private $authenticatorMock;

    protected function setUp()
    {
        $this->categoryRepositoryMock = $this->prophesize(CategoryRepository::class);
        $this->restaurantRepositoryMock = $this->prophesize(RestaurantRepository::class);
        $this->authenticatorMock = $this->prophesize(Authenticator::class);

        $this->sut = new AddRestaurantUseCase(
            $this->categoryRepositoryMock->reveal(),
            $this->restaurantRepositoryMock->reveal(),
            $this->authenticatorMock->reveal()
        );
    }

    public function test_when_restaurant_name_is_empty_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $name = '';
        $addRestaurantRequest = new AddRestaurantRequest($name, 'city', 'indian', 'jwt');
        $this->sut->execute($addRestaurantRequest);
    }

    public function test_when_city_is_empty_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $city = '';
        $addRestaurantRequest = new AddRestaurantRequest('restaurant name', $city, 'indian', 'jwt');
        $this->sut->execute($addRestaurantRequest);
    }

    public function test_when_category_is_empty_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $category = '';
        $addRestaurantRequest = new AddRestaurantRequest('restaurant name', 'Barcelona', $category, 'jwt');
        $this->sut->execute($addRestaurantRequest);
    }

    public function test_when_category_is_invalid_should_throw_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidCategory = 'invalid category';
        $this->categoryRepositoryMock->findByName($invalidCategory)
            ->shouldBeCalled()
            ->willReturn(null);

        $addRestaurantRequest = new AddRestaurantRequest('restaurant name', 'Barcelona', $invalidCategory, 'jwt');
        $this->sut->execute($addRestaurantRequest);
    }

    public function test_when_all_the_data_is_valid_should_create_the_new_restaurant()
    {
        $categoryName = 'chinese';

        $category = new Category(1, 'chinese', 'China');
        $this->categoryRepositoryMock->findByName($categoryName)
            ->shouldBeCalled()
            ->willReturn($category);

        $user = User::register(new UserId(Uuid::fromString('user_id')), 'hello@example.com', 'username', 'password');
        $restaurant = new Restaurant(null, 'La masía', 'Barcelona', $user, $category, null);
        $this->restaurantRepositoryMock->save($restaurant)
            ->shouldBeCalled()
            ->willReturn($restaurant);

        $addRestaurantRequest = new AddRestaurantRequest('La masía', 'Barcelona', $categoryName, 'jwt');
        $this->sut->execute($addRestaurantRequest);
    }
}
