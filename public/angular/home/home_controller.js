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
            function ($http, $state, $scope, $sce) {

                $scope.previousPage = function() {
                    if ($scope.currentPage > 1) {
                        var pageToGo = $scope.currentPage - 1;
                        loadPage(pageToGo);
                    }
                };

                $scope.nextPage = function() {
                    if ($scope.currentPage < $scope.totalPages) {
                        var pageToGo = $scope.currentPage + 1;
                        loadPage(pageToGo);
                    }
                };


                var loadPage = function (pageNumber) {
                    $http({
                        method: 'GET',
                        url: '/api/restaurants',
                        params: {page: pageNumber}
                    }).success(function (data) {
                        $scope.restaurants = data.restaurants;
                        $scope.paginationHtml = $sce.trustAsHtml(data.pagination.paginationHtml);
                        $scope.currentPage = data.pagination.currentPage;
                        $scope.totalPages = data.pagination.totalPages;

                        if ($scope.currentPage === 1) {
                            $( ".js-all-restaurants-previous" ).addClass( "disabled" );
                        } else {
                            $( ".js-all-restaurants-previous" ).removeClass( "disabled" );
                        }
                        if ($scope.currentPage === $scope.totalPages) {
                            $( ".js-all-restaurants-next" ).addClass( "disabled" );
                        } else {
                            $( ".js-all-restaurants-next" ).removeClass( "disabled" );

                        }

                    }).error(function (data, status, headers, config) {
                        console.log('Userpage error.');
                    });
                };

                loadPage(1);

            }
        ]
    );
