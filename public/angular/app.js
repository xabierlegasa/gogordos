'use strict';

angular.module('myapp', [
    'ui.router',
    'myapp.signUp',
    'myapp.accountBox',
    'myapp.login',
    'myapp.focus',
    'myapp.account',
    'myapp.newRestaurant'
])

    .config(function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider
            .otherwise('/');

        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: 'templates/home.html',
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
            .state('login', {
                url: '/login',
                templateUrl: 'templates/users/login.html',
                controller: 'LoginController',
                controllerAs: 'loginCtrl'
            })
            .state('account', {
                url: '/account',
                templateUrl: 'templates/users/account.html',
                controller: 'AccountController',
                controllerAs: 'accountCtrl'
            })
            .state('newRestaurant', {
                url: '/newRestaurant',
                templateUrl: 'templates/restaurants/newRestaurant.html',
                controller: 'NewRestaurantController',
                controllerAs: 'newRestaurantCtrl'
            })
        ;
    })

    // TODO, move all this to its own file, so we only have routes here
    .controller('ListController',
        [
            '$scope',
            '$http',
            '$localStorage',
            '$sessionStorage',
            '$rootScope',
            function ($scope, $http, $localStorage, $sessionStorage, $rootScope) {
                $scope.placeList = [
                    {name: 'Chino chino', city: 'Barcelona'},
                    {name: 'Vega', city: 'Madrid'}
                ];

                $scope.selectItem = function (item) {
                    console.log('item clicked: ' + item.name);
                };
            }
        ]
    )


    .controller('ItemController', ['$scope', '$stateParams', function ($scope, $stateParams) {
        console.log('Go get this item from the server: ' + $stateParams.item);
        $scope.item = $stateParams.item;
    }])
;
;
