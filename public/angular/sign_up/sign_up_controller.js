angular.module('myapp.signUp', [
    'ui.router',
    'ngStorage'
])

    .controller('SignUpController',
        [
            '$http',
            '$state',
            '$scope',
            '$rootScope',
            '$localStorage',
            function ($http, $state, $scope, $rootScope, $localStorage) {

                var controller = this;
                this.user = {};

                this.register = function (user) {
                    controller.errors = null;

                    $http({
                        method: 'POST',
                        url: '/api/users',
                        data: user,
                    }).success(function (data) {
                        controller.response = data;

                        if (data.status == 'success') {
                            $localStorage.jwt = data.jwt;
                            $rootScope.$broadcast('user-registered', {user: user});
                            $state.go('home');
                        } else {
                            console.log('data status is not success. Show the erro.r message');
                        }
                    }).catch(function (user) {
                        controller.errors = user.data.error;
                    });
                };

            }
        ]
    );
