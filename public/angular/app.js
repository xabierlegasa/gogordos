'use strict';

angular.module('myapp', [
    'ui.router',
    'myapp.signUp',
    'myapp.accountBox',
    'myapp.login',
    'myapp.focus',
    'myapp.account',
    'myapp.newRestaurant',
    'myapp.userPage',
    'myapp.home',
    'myapp.addFriend',
    'ui.select',
    'ngSanitize',
    'myapp.cityRestaurants',
    'myapp.restaurantDirective',
    'myapp.myRestaurants'
])

    .filter('ucfirst', function () {
        return function (input, arg) {
            return input.replace(/(?:^|\s)\S/g, function (a) {
                return a.toUpperCase();
            });
        };
    })

    .config(["$locationProvider", function ($locationProvider) {
        $locationProvider.html5Mode(true);
    }])

    .config(function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider
            .otherwise('/');

        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: 'templates/home.html',
                controller: 'HomeController',
                controllerAs: 'homeCtrl'
            })
            .state('signup', {
                url: '/g/signup',
                templateUrl: 'templates/users/signUp.html',
                controller: 'SignUpController',
                controllerAs: 'signUpCtrl'
            })
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
            .state('addFriend', {
                url: '/g/addFriend',
                templateUrl: 'templates/users/addFriend.html',
                controller: 'AddFriendController',
                controllerAs: 'addFriendCtrl'
            })
            .state('cityRestaurants', {
                url: '/g/city/:city',
                templateUrl: 'templates/city/city_restaurants.html',
                controller: 'CityRestaurantsController',
                controllerAs: 'cityRestaurantsCtrl'
            })
            .state('myRestaurants', {
                url: '/g/my-places',
                templateUrl: 'templates/users/my_restaurants.html',
                controller: 'MyRestaurantsController',
                controllerAs: 'myRestaurantsCtrl'
            })
        ;
    })

;
