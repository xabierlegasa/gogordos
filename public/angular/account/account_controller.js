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
                console.log('account controller now!');
                console.log($rootScope);
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
            }
        ]
    );
