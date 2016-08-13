<?php

namespace Tests\Application\Controllers;


use Gogordos\Application\Controllers\ControllerResponseJson;
use Gogordos\Application\Controllers\Response\ControllerResponseJsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\AddRestaurantController;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantRequest;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantUseCase;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class AddRestaurantControllerTest extends TestCase
{
    /** @var AddRestaurantController */
    private $sut;

    /** @var AddRestaurantUseCase */
    private $addRestaurantUseCaseMock;

    protected function setUp()
    {
        $this->addRestaurantUseCaseMock = $this->prophesize(AddRestaurantUseCase::class);
        $this->sut = new AddRestaurantController(
            $this->addRestaurantUseCaseMock->reveal()
        );
    }

    public function test_when_use_case_throws_an_invalid_argument_exception_should_return_json_with_error_code()
    {
        $requestMock = $this->prophesize(Request::class);
        $requestMock->getParam('restaurant_name')->shouldBeCalled()
            ->willReturn('La Tratoria');
        $requestMock->getParam('restaurant_city')->shouldBeCalled()
            ->willReturn('Roma');
        $requestMock->getParam('restaurant_category')->shouldBeCalled()
            ->willReturn('invalid category');
        $requestMock->getParam('jwt')->shouldBeCalled()
            ->willReturn('jwt');

        $this->addRestaurantUseCaseMock->execute(new AddRestaurantRequest('La Tratoria', 'roma', 'invalid category', 'jwt'))
            ->shouldBeCalled()
            ->willThrow(new \InvalidArgumentException('La categoría no es válida'));

        /** @var JsonBadRequest $controllerResponseJson */
        $response = $this->sut->addRestaurant($requestMock->reveal());

        $this->assertEquals(400, $response->httpCode());
        $this->assertEquals('La categoría no es válida', $response->data()['errorMessage']);
    }
}
