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

                        // TODO: Go to recommendation page

                        // if (data.status == 'success') {
                        //     $localStorage.jwt = data.jwt;
                        //     $rootScope.$broadcast('user-signed-up', {user: user});
                        //     $state.go('home');
                        // } else {
                        //     console.log('data status is not success. Show the erro.r message');
                        // }
                    }).error(function (data, status, headers, config) {
                        console.log('error. do something!');
                    });
                };
            }
        ]
    );
