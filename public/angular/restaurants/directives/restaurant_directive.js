angular.module('myapp.restaurantDirective', [
    'ui.router',
    'ngStorage'
])

    .directive("ggRestaurantSnippet", function () {
        return {
            restrict: 'E',
            templateUrl: 'angular/restaurants/directives/restaurantSnippet.html',
            replace: true
        };
    });
