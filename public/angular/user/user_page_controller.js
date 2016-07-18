angular.module('myapp.userPage', [
    'ui.router'
])

    .controller('UserPageController',
        [
            '$http',
            '$state',
            '$scope',
            '$stateParams',
            function ($http, $state, $scope, $stateParams) {
                var username = $stateParams.username;


                $http({
                    method: 'GET',
                    url: '/api/users/restaurants',
                    params: {username: username}
                }).success(function (data) {


                }).error(function (data, status, headers, config) {
                    console.log('Userpage error.');
                });

                console.log('user page controller');
            }
        ]
    );
