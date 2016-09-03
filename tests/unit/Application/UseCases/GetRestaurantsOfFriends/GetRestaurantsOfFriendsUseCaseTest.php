<?php

namespace Tests\Application\UseCases\GetRestaurantsOfFriends;

use Gogordos\Application\Exceptions\AuthenticationException;
use Gogordos\Application\Exceptions\UserIsNotAuthenticatedException;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsRequest;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsResponse;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsUseCase;
use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Services\Authenticator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Helpers\CategoryHelpers;

class GetRestaurantsOfFriendsUseCaseTest extends TestCase
{
    use CategoryHelpers;

    /** @var GetRestaurantsOfFriendsUseCase */
    private $sut;

    /** @var Authenticator */
    private $authenticatorMock;

    /** @var RestaurantRepository */
    private $restaurantsRepositoryMock;

    protected function setUp()
    {
        $this->authenticatorMock = $this->prophesize(Authenticator::class);
        $this->restaurantsRepositoryMock = $this->prophesize(RestaurantRepository::class);

        $this->sut = new GetRestaurantsOfFriendsUseCase(
            $this->authenticatorMock->reveal(),
            $this->restaurantsRepositoryMock->reveal()
        );
    }

    public function test_when_user_is_authenticated_and_has_friends_with_restaurants_should_return_those_restaurants()
    {
        $userId = new UserId(Uuid::fromString('116c6634-8bb4-445d-957f-cb4b2c4a3e8f'));

        $jwt = 'valid jwt';
        $page = 3;
        $rpp = 2;

        $this->authenticatorMock
            ->authUserDataFromToken($jwt)
            ->shouldBeCalled()
            ->willReturn(new AuthUserData($userId, 'xabi'));

        $restaurants = [
            new Restaurant(1, 'Mediterrania', 'Barcelona', '', $this->buildCategory(), $userId, 'reason', null),
            new Restaurant(1, 'El Rancho', 'Donostia', '', $this->buildCategory(), $userId, 'reason', null)
        ];
        $offset =
        $this->restaurantsRepositoryMock
            ->findByUserFriends($userId, 4, $rpp)
            ->shouldBeCalled()
            ->willReturn(
                $restaurants
            );

        $this->restaurantsRepositoryMock
            ->findByUserFriendsTotal($userId)
            ->shouldBeCalled()
            ->willReturn(
                100
            );

        /** @var GetRestaurantsOfFriendsResponse $respose */
        $response = $this->sut->execute(new GetRestaurantsOfFriendsRequest($jwt, $page, $rpp));
        $restaurants = $response->restaurants;

        $this->assertEquals($page, $response->page);
        $this->assertEquals(2, count($restaurants));
    }

//    public function test_when_authentication_token_is_empty_should_return_correct_error()
//    {
//        $this->expectException(AuthenticationException::class);
//        $jwt = 'invalid token';
//        $page = 2;
//        $rpp = 2;
//
//        $this->authenticatorMock
//            ->authUserDataFromToken($jwt)
//            ->shouldBeCalled()
//            ->willThrow(new AuthenticationException());
//
//        $this->sut->execute(new GetRestaurantsOfFriendsRequest($jwt, $page, $rpp));
//    }
}
