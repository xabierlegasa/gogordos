angular.module('myapp.cityRestaurants', [
    'ui.router',
    'ngStorage'
])
    .controller('CityRestaurantsController',
        [
            '$http',
            '$state',
            '$scope',
            '$localStorage',
            '$stateParams',
            function ($http, $state, $scope, $localStorage, $stateParams) {
                var city = $stateParams.city;
                $scope.cityTitle = titleCase(city);

                //  start City Restaurants --------------------------------------------------------
                $scope.previousPage = function () {
                    if ($scope.restaurantsCurrentPage > 1) {
                        var pageToGo = $scope.currentPage - 1;
                        loadCityRestaurants(pageToGo);
                    }
                };

                $scope.nextPage = function () {
                    if ($scope.restaurantsCurrentPage < $scope.totalPages) {
                        var pageToGo = $scope.restaurantsCurrentPage + 1;
                        loadCityRestaurants(pageToGo);
                    }
                };


                var loadCityRestaurants = function (pageNumber) {
                    $http({
                        method: 'GET',
                        url: '/api/city/restaurants',
                        params: {page: pageNumber, city: city}
                    }).success(function (data) {
                        $scope.restaurants = data.restaurants;
                        $scope.restaurantsCurrentPage = data.pagination.currentPage;
                        $scope.totalPages = data.pagination.totalPages;

                        if ($scope.restaurantsCurrentPage === 1) {
                            $(".js-city-restaurants-previous").addClass("disabled");
                        } else {
                            $("li.js-city-restaurants-previous").removeClass("disabled");
                        }

                        if ($scope.restaurantsCurrentPage === $scope.totalPages
                            || $scope.restaurantsCurrentPage > $scope.totalPages
                        ) {
                            $(".js-city-restaurants-next").addClass("disabled");
                        } else {
                            $(".js-city-restaurants-next").removeClass("disabled");
                        }

                    }).error(function (data, status, headers, config) {
                        console.log('Error!!');
                    });
                };
                //  end City Restaurants --------------------------------------------------------

                loadCityRestaurants(1);

            }
        ]
    );


function titleCase(str) {
    var splitStr = str.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
        // You do not need to check if i is larger than splitStr length, as your for does that for you
        // Assign it back to the array
        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
    }
    // Directly return the joined string
    return splitStr.join(' ');
}
