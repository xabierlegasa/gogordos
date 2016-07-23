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
    'myapp.home'
])

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
        ;
    })

;
