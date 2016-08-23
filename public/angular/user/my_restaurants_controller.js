angular.module('myapp.myRestaurants', [
    'ui.router'
])

    .controller('MyRestaurantsController',
        [
            '$http',
            '$state',
            '$scope',
            '$localStorage',
            function ($http, $state, $scope, $localStorage) {

                var jwt = $localStorage.jwt;
                console.log('fooooo');
                $http({
                    method: 'GET',
                    url: '/api/my-restaurants',
                    params: {jwt: jwt}
                }).success(function (data) {
                    $scope.restaurants = data.restaurants;
                }).error(function (data, status, headers, config) {
                    console.log('Userpage error.');
                });
            }
        ]
    );







