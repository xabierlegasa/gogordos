angular.module('myapp.newRestaurant', [
    'ui.router',
    'ngStorage'
])

    .controller('NewRestaurantController',
        [
            '$http',
            '$state',
            '$scope',
            '$rootScope',
            '$localStorage',
            'focus',
            function ($http, $state, $scope, $rootScope, $localStorage, focus) {

                console.log('new restaurant controller')

            }
        ]
    );
