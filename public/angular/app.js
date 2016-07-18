'use strict';

angular.module('myapp', [
    'ui.router',
    'myapp.signUp',
    'myapp.accountBox',
    'myapp.login',
    'myapp.focus',
    'myapp.account',
    'myapp.newRestaurant',
    'myapp.userPage'
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
                url: '/g/signup',
                templateUrl: 'templates/users/signUp.html',
                controller: 'SignUpController',
                controllerAs: 'signUpCtrl'
            })
            // .state('home.item', {
            //     url: '/:item',
            //     templateUrl: 'templates/places/list.item.html',
            //     controller: 'ItemController',
            // })
            .state('login', {
                url: '/g/login',
                templateUrl: 'templates/users/login.html',
                controller: 'LoginController',
                controllerAs: 'loginCtrl'
            })
            .state('account', {
                url: '/g/account',
                templateUrl: 'templates/users/account.html',
                controller: 'AccountController',
                controllerAs: 'accountCtrl'
            })
            .state('newRestaurant', {
                url: '/g/newRestaurant',
                templateUrl: 'templates/restaurants/newRestaurant.html',
                controller: 'NewRestaurantController',
                controllerAs: 'newRestaurantCtrl'
            })
            .state('userPage', {
                url: '/:username',
                templateUrl: 'templates/users/userPage.html',
                controller: 'UserPageController',
                controllerAs: 'userPagesCtrl'
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
