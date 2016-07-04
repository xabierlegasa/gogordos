(function () {

    console.log('load app.js file');

    var app = angular.module('GogordosApp', ['ngRoute']);

    app.controller('SignUpController', ['$http', function ($http) {
        console.log('SignUpController start');

        this.user = {};

        this.register = function (user) {
            console.log('user email is:' + user.email);
            $http.post('/api/users', {foo: 'bar'}).success(function (data) {

            });
        }

    }]);
})();