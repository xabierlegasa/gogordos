

angular.module('myapp.login', [
    'ui.router',
    'ngStorage'
])

    .controller('LoginController',
        [
            '$http',
            '$state',
            '$scope',
            '$rootScope',
            '$localStorage',
            'focus',
            function ($http, $state, $scope, $rootScope, $localStorage, focus) {

                var controller = this;
                this.credentials = {};
                focus('emailOrUsername');
                this.login = function (credentials) {
                    controller.errors = null;

                    $http({
                        method: 'POST',
                        url: '/api/login',
                        data: credentials,
                    }).success(function (data) {
                        controller.response = data;

                        if (data.status == 'success') {
                            $localStorage.jwt = data.jwt;
                            $rootScope.$broadcast('user-logged-in', {username: data.username});
                            $rootScope.loggedIn = true;
                            $rootScope.username = data.username;
                            $state.go('home');
                        } else {
                            console.log('data status is not success. Show the error message');
                        }
                    }).catch(function (user) {
                        controller.errors = user.data.error;
                    });
                };

            }
        ]
    );
