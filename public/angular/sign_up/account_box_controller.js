angular.module('myapp.accountBox', [
    'ui.router',
    'ngStorage'
])

    .controller('AccountBoxController',
        [
            '$scope',
            '$http',
            '$localStorage',
            function ($scope, $http, $localStorage) {
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
                        $scope.account.username = data.user.username;

                    }).catch(function (user) {
                        console.log('yuuuups error');
                    });
                }

                $scope.$on('user-registered', function (event, args) {
                    console.log('user-registered event listened');
                    $scope.loggedIn = true;
                    $scope.account.username = args.user.username;
                });

            }
        ]
    )

;