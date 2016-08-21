angular.module('myapp.account', [
    'ui.router',
    'ngStorage'
])

    .controller('AccountController',
        [
            '$http',
            '$state',
            '$scope',
            '$rootScope',
            '$localStorage',
            function ($http, $state, $scope, $rootScope, $localStorage) {
                $scope.user = {};

                var jwt = $localStorage.jwt;
                $http({
                    method: 'GET',
                    url: '/api/account',
                    params: {jwt: jwt}
                }).success(function (data) {
                    $scope.user.username = data.user.username;
                    $scope.user.email = data.user.email;
                }).error(function (data, status, headers, config) {
                    $scope.errorMessage = data.errorMessage;
                });

                this.logout = function() {
                    // delete jwt token, so we are not logged in anymore
                    delete $localStorage.jwt;
                    $rootScope.$broadcast('user-logged-out');
                    $state.go('home');
                };

                var jwt = $localStorage.jwt;
                $http({
                    method: 'GET',
                    url: '/api/account',
                    params: {jwt: jwt}
                }).then(function (data) {
                    var username = data.data.user.username;
                    $http({
                        method: 'GET',
                        url: '/api/following',
                        params: {'username': username}
                    }).then(function (data) {
                        $scope.following = data.data.users.length;
                        console.log($scope.following);
                    });
                });

            }
        ]
    );
