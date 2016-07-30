angular.module('myapp.home', [
    'ui.router',
    'ngStorage'
])
    .controller('HomeController',
        [
            '$http',
            '$state',
            '$scope',
            '$sce',
            '$localStorage',
            function ($http, $state, $scope, $sce, $localStorage) {


                //  start ALL RESTAURANTS --------------------------------------------------------
                $scope.previousPage = function() {
                    if ($scope.allRestaurantsCurrentPage > 1) {
                        var pageToGo = $scope.currentPage - 1;
                        loadAllRestaurants(pageToGo);
                    }
                };

                $scope.nextPage = function() {
                    if ($scope.allRestaurantsCurrentPage < $scope.totalPages) {
                        var pageToGo = $scope.allRestaurantsCurrentPage + 1;
                        loadAllRestaurants(pageToGo);
                    }
                };


                var loadAllRestaurants = function (pageNumber) {
                    $http({
                        method: 'GET',
                        url: '/api/restaurants',
                        params: {page: pageNumber}
                    }).success(function (data) {
                        $scope.restaurants = data.restaurants;
                        $scope.allRestaurantsCurrentPage = data.pagination.currentPage;
                        $scope.totalPages = data.pagination.totalPages;

                        if ($scope.allRestaurantsCurrentPage === 1) {
                            $( ".js-all-restaurants-previous" ).addClass( "disabled" );
                        } else {
                            $( ".js-all-restaurants-previous" ).removeClass( "disabled" );
                        }
                        if ($scope.allRestaurantsCurrentPage === $scope.totalPages) {
                            $( ".js-all-restaurants-next" ).addClass( "disabled" );
                        } else {
                            $( ".js-all-restaurants-next" ).removeClass( "disabled" );

                        }

                    }).error(function (data, status, headers, config) {
                        console.log('Userpage error.');
                    });
                };
                //  end ALL RESTAURANTS --------------------------------------------------------


                //  start MY FRIENDS RESTAURANTS --------------------------------------------------------


                $scope.friendsRestaurantsPreviousPage = function () {
                    if ($scope.friendcurrentPage > 1) {
                        var pageToGo = $scope.friendcurrentPage - 1;
                        loadFriendRestaurants(pageToGo);
                    }
                };

                $scope.friendsRestaurantsNextPage = function () {
                    if ($scope.friendcurrentPage < $scope.totalPages) {
                        var pageToGo = $scope.friendcurrentPage + 1;
                        loadFriendRestaurants(pageToGo);
                    }
                };

                var loadFriendRestaurants = function (pageNumber) {
                    var jwt = $localStorage.jwt;

                    $http({
                        method: 'GET',
                        url: '/api/friends/restaurants',
                        params: {page: pageNumber, jwt: jwt}
                    }).success(function (data) {
                        $scope.friendRestaurants = data.restaurants;
                        $scope.friendcurrentPage = data.pagination.currentPage;
                        $scope.friendTotalPages = data.pagination.totalPages;

                        if ($scope.friendcurrentPage === 1) {
                            $(".js-friend-restaurants-previous").addClass("disabled");
                        } else {
                            $(".js-friend-restaurants-previous").removeClass("disabled");
                        }
                        if ($scope.friendcurrentPage === $scope.friendTotalPages) {
                            $(".js-friend-restaurants-next").addClass("disabled");
                        } else {
                            $(".js-friend-restaurants-next").removeClass("disabled");

                        }
                    }).error(function (data, status, headers, config) {
                        console.log('Userpage error.');
                    });
                };
                //  end MY FRIENDS RESTAURANTS --------------------------------------------------------


                loadAllRestaurants(1);
                loadFriendRestaurants(1);
            }
        ]
    );
