angular.module('myapp.newRestaurant', [
    'ui.router',
    'ngStorage'
])

    .controller('NewRestaurantController',
        [
            '$http',
            '$state',
            '$scope',
            '$rootScope',
            '$localStorage',
            'focus',
            function ($http, $state, $scope, $rootScope, $localStorage, focus) {
                $scope.categories = {};

                $http({
                    method: 'GET',
                    url: '/api/categories',
                    params: {}
                }).success(function (data) {
                    $scope.categories = data.categories;
                }).error(function (data, status, headers, config) {
                    console.log('error obtaining categories');
                });

                this.create = function (restaurant) {
                    $http({
                        method: 'POST',
                        url: '/api/restaurants',
                        data: {
                            'restaurant_name': restaurant.name,
                            'restaurant_city': restaurant.city,
                            'restaurant_category': restaurant.category,
                            'restaurant_reason': restaurant.reason,
                            'jwt': $localStorage.jwt
                        }
                    }).then(function (data) {
                        console.log('new restaurant controller responseeee');
                        $scope.errorMessage = '';
                        $scope.successMessage = 'Tienes un nuevo sitio favorito!';
                    });
                };
            }
        ]
    );
