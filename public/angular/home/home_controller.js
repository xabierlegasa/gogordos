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
                        var pageToGo = $scope.allRestaurantsCurrentPage - 1;
                        console.log('go to page ' + pageToGo);

                        loadAllRestaurants(pageToGo);
                    }
                };

                $scope.nextPage = function() {
                    if ($scope.allRestaurantsCurrentPage < $scope.totalPages) {
                        var pageToGo = $scope.allRestaurantsCurrentPage + 1;
                        console.log('go to page ' + pageToGo);
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
                            $scope.isAllPreviousEnabled = false;
                        } else {
                            $( ".js-all-restaurants-previous" ).removeClass( "disabled");
                            $scope.isAllPreviousEnabled = true;
                        }
                        if ($scope.allRestaurantsCurrentPage === $scope.totalPages) {
                            $( ".js-all-restaurants-next" ).addClass( "disabled" );
                            $scope.isAllNextEnabled = false;
                        } else {
                            $( ".js-all-restaurants-next" ).removeClass( "disabled" );
                            $scope.isAllNextEnabled = true;

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

                    if (jwt) {
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
                                $scope.isFriendsPreviousEnabled = false;
                            } else {
                                $(".js-friend-restaurants-previous").removeClass("disabled");
                                $scope.isFriendsPreviousEnabled = true;
                            }

                            if ($scope.friendcurrentPage === $scope.friendTotalPages) {
                                $(".js-friend-restaurants-next").addClass("disabled");
                                $scope.isFriendsNextEnabled = false;
                            } else {
                                $(".js-friend-restaurants-next").removeClass("disabled");
                                $scope.isFriendsNextEnabled = true;
                            }
                        }).error(function (data, status, headers, config) {
                            console.log('Userpage error.');
                        });
                    }


                };
                //  end MY FRIENDS RESTAURANTS --------------------------------------------------------

                //  start LOAD HOME PAGE USER DATA ----------------------------------------------------

                $scope.following_number = 0;
                $scope.followers_number = 0;
                var loadHomePageUserData = function () {
                    var jwt = $localStorage.jwt;

                    if (jwt) {
                        $http({
                            method: 'GET',
                            url: '/api/home-page-user-data',
                            params: {jwt: jwt}
                        }).success(function (data) {
                            $scope.following_number = data.following_number;
                            $scope.followers_number = data.followers_number;
                            $scope.restaurants_number = data.restaurants_number;
                        }).error(function (data, status, headers, config) {
                            console.log('HomePage user data error.');
                        });
                    }
                };
                //  end LOAD HOME PAGE USER DATA ----------------------------------------------------



                loadAllRestaurants(1);
                loadFriendRestaurants(1);
                loadHomePageUserData();
            }
        ]
    );
