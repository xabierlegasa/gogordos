'use strict';

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
                views: {
                    'main': {
                        url: '/home',
                        templateUrl: 'templates/places/list.html',
                        controller: 'ListController',
                        controllerAs: 'listCtrl'
                    },
                    'accountBox': {
                        url: '/home',
                        templateUrl: 'templates/users/accountBox.html',
                        controller: 'AccountBoxController',
                        controllerAs: 'accountBoxCtrl'
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
                    },
                    'accountBox': {
                        url: '/signup',
                        templateUrl: 'templates/users/accountBox.html',
                        controller: 'AccountBoxController',
                        controllerAs: 'accountBoxCtrl'
                    }
                }
            })
            .state('home.item', {
                url: '/:item',
                templateUrl: 'templates/places/list.item.html',
                controller: 'ItemController',
            })
        ;
    })

    .controller('AccountBoxController',
        [
            '$scope',
            '$http',
            '$localStorage',
            function ($scope, $http, $localStorage) {
                var jwt = $localStorage.jwt;
                $scope.loggedIn = false;
                
                if (typeof jwt == "undefined") {
                    // keep default view with register+login buttons
                    console.log('no jwt param');
                } else {
                    console.log('jwt: ' + jwt);
                    // Check with the jwt logged in data
                    $http({
                        method: 'GET',
                        url: '/api/auth',
                        params: {jwt: jwt}
                    }).success(function (data) {

                        console.log('answer from auth:');
                        console.log(data.user.username);
                        $scope.loggedIn = true;

                    }).catch(function (user) {
                        console.log('yuuuups error');
                        controller.errors = user.data.error;
                    });
                }
            }
        ]
    )

    .controller('ListController',
        [
            '$scope',
            '$http',
            '$localStorage',
            '$sessionStorage',
            function ($scope, $http, $localStorage, $sessionStorage) {
                $scope.foo = 'bar';

                

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
