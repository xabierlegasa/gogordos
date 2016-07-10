angular.module('myapp.accountBox', [
    'ui.router',
    'ngStorage'
])

    .controller('AccountBoxController',
        [
            '$scope',
            '$http',
            '$localStorage',
            '$rootScope',
            function ($scope, $http, $localStorage, $rootScope) {
                var jwt = $localStorage.jwt;
                $scope.loggedIn = false;
                $scope.account = {};

                if (typeof jwt == "undefined") {
                    // keep default view with register+login buttons
                    console.log('no jwt param');
                } else {
                    // Check with the jwt logged in data
                    $http({
                        method: 'GET',
                        url: '/api/auth',
                        params: {jwt: jwt}
                    }).success(function (data) {
                        $scope.loggedIn = true;
                        $scope.username = data.user.username;
                        $rootScope.loggedIn = true;
                    }).error(function (data, status, headers, config) {
                        console.log('Auth error.');
                    });
                }   

                $scope.$on('user-signed-up', function (event, args) {
                    console.log('user-signed-up event listened');
                    $scope.loggedIn = true;
                    $scope.username = args.user.username;
                    $rootScope.loggedIn = true;
                });

                $scope.$on('user-logged-in', function (event, args) {
                    console.log('user-logged-in event listened. Args:');
                    $scope.loggedIn = true;
                    $scope.username = args.username;
                });
                
                $scope.$on('user-logged-out', function () {
                    console.log('user-logged-out event linstened');
                    $scope.loggedIn = false;
                    $scope.account = null;
                });

            }
        ]
    )

;