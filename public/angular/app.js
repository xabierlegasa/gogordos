'use strict';

angular.module('myapp', [
    'ui.router',
    'myapp.signUp',
    'myapp.accountBox'
])

    .config(function ($stateProvider) {
        $stateProvider
            .state('home', {
                views: {
                    'main': {
                        url: '/home',
                        templateUrl: 'templates/places/list.html',
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
        ;
    })

// TODO, move all this to its own file, so we only have routes here
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
