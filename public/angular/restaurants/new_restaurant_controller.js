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
                            'jwt': $localStorage.jwt
                        }
                    }).success(function (data) {
                        $scope.errorMessage = '';
                        $scope.successMessage = 'Tienes un nuevo sitio favorito!';
                    }).error(function (data, status, headers, config) {
                        $scope.errorMessage = data.errorMessage;
                    });
                };
            }
        ]
    );
