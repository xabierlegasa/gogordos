'use strict';

angular.module('myapp', [
    'ui.router',
    'myapp.signUp',
    'myapp.accountBox',
    'myapp.login',
    'myapp.focus',
    'myapp.account'
])

    .config(function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider
            .otherwise('/');

        $stateProvider
            .state('home', {
                views: {
                    'main': {
                        url: '/',
                        templateUrl: 'templates/home.html',
                        controller: 'ListController',
                        controllerAs: 'listCtrl'
                    }
                }
            })
            .state('signup', {
                views: {
                    'main': {
                        url: '/signup',
                        templateUrl: 'templates/users/signUp.html',
                        controller: 'SignUpController',
                        controllerAs: 'signUpCtrl'
                    }
                }
            })
            .state('home.item', {
                url: '/:item',
                templateUrl: 'templates/places/list.item.html',
                controller: 'ItemController',
            })
            .state('login', {
                views: {
                    'main': {
                        url: '/login',
                        templateUrl: 'templates/users/login.html',
                        controller: 'LoginController',
                        controllerAs: 'loginCtrl'
                    }
                }
            })
            .state('account', {
                views: {
                    'main': {
                        url: '/account',
                        templateUrl: 'templates/users/account.html',
                        controller: 'AccountController',
                        controllerAs: 'accountCtrl'
                    }
                }
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
                console.log($rootScope);
                // $scope.loggedIn = $rootScope.loggedIn;
                // if ("loggedIn" in $rootScope) {
                //     console.log('the variable is defined');
                // } else {
                //     console.log('the variable is NOT defined');
                // }


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
