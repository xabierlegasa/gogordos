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
                        console.log('success!');
                        $state.go('home');

                    }).catch(function (user) {
                        controller.errors = user.data.error;
                    });
                };

            }
        ]
    );
