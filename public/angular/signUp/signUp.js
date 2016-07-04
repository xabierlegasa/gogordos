'use strict';

angular.module('myApp.signUp', ['ngRoute'])

    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/SignUp', {
            templateUrl: 'angular/signUp/signUp.html',
            controller: 'SignUpCtrl',
            controllerAs: 'signUpCtrl'
        });
    }])
    .controller('SignUpCtrl', ['$http', function ($http) {
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
                    console.log('redireeeect');
                    redirectTo: '/';
                } else {
                    console.log('eeeee');
                }
            }).catch(function(user) {
                controller.errors = user.data.error;
            });
        };

    }]);

