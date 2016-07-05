'use strict';
//
// // Declare app level module which depends on views, and components
// angular.module('myApp', [
//     'ngRoute',
//     'myApp.view1',
//     'myApp.signUp'
// ]).
// config(['$locationProvider', '$routeProvider', function($locationProvider, $routeProvider) {
//     $locationProvider.hashPrefix('!');
//
//     $routeProvider.otherwise({redirectTo: '/'});
// }]);


angular.module('myapp', [
    'ui.router',
    'myapp.signUp'
])

    .config(function ($stateProvider, $urlRouterProvider) {
        //
        // // For any unmatched url, send to /state1
        // $urlRouterProvider.otherwise("/state1")

        $stateProvider
            .state('home', {
                url: '/home',
                templateUrl: 'templates/places/list.html',
                controller: 'ListController',
                controllerAs: 'listCtrl'
            })
            .state('signup', {
                url: '/signup',
                templateUrl: 'templates/users/signUp.html',
                controller: 'SignUpController',
                controllerAs: 'signUpCtrl'
            })
            .state('home.item', {
                url: '/:item',
                templateUrl: 'templates/places/list.item.html',
                controller: 'ItemController',
            })
        ;
    })


    .controller('ListController',
        [
            '$scope',
            '$http',
            '$localStorage',
            '$sessionStorage',
            function ($scope, $http, $localStorage, $sessionStorage) {
                console.log();
                var jwt = $localStorage.jwt;
                if (typeof jwt == "undefined") {
                    // TODO redirect to login page now!
                    console.log('no jwt. Go to login view');
                } else {
                    console.log('get user from jwt');
                    // Check with the jwt logged in data
                    $http({
                        method: 'GET',
                        url: '/api/auth/user',
                        data: jwt,
                    }).success(function (data) {

                        console.log('answer from auth:');
                        console.log(data);

                        // controller.response = data;
                        //
                        // if (data.status == 'success') {
                        //     console.log(data.jwt);
                        //     console.log('now go home');
                        //     $localStorage.jwt = data.jwt;
                        //
                        //     $state.go('home');
                        // } else {
                        //     console.log('data status is not success. Show the erro.r message');
                        // }
                    }).catch(function (user) {
                        console.log('yuuuups error');
                        controller.errors = user.data.error;
                    });
                }

                $scope.placeList = [
                    {name: 'Chino chino', city: 'Barcelona'},
                    {name: 'Vega', city: 'Madrid'}
                ];

                $scope.selectItem = function (item) {
                    console.log('item clicked: ' + item.name);
                };
            }])

    .controller('ItemController', ['$scope', '$stateParams', function ($scope, $stateParams) {
        console.log('Go get this item from the server: ' + $stateParams.item);
        $scope.item = $stateParams.item;
    }])


;
;
