angular.module('myapp.addFriend', [
    'ui.router'
])

    .controller('AddFriendController',
        [
            '$http',
            '$state',
            '$scope',
            '$location',
            'appConstants',
            function ($http, $state, $scope, $location, appConstants) {
                console.log('appConstants.ApiBaseUrl: ' + appConstants.ApiBaseUrl);
                $scope.ApiBaseUrl = appConstants.ApiBaseUrl;
                $scope.itemArray = [];
                $scope.selected = {};
                $scope.isValid = false;
                $scope.selectedItem = {};

                $scope.refreshUsers = function(term) {
                    if (term.length > 2) {
                        $http({
                            method: 'GET',
                            url: $scope.ApiBaseUrl + '/users',
                            params: {terms: term}
                        }).success(function (data) {
                            var items = [];
                            for (i = 0; i < data.users.length; i++) {
                                items.push({id: data.users[i].username, name:data.users[i].username});
                            }
                            $scope.itemArray = items;
                        }).error(function (data, status, headers, config) {
                            console.log('error obtaining users');
                        });
                    }
                };

                $scope.itemSelected = function (selectedItem) {

                    console.log('item selecteeed');
                    console.log(selectedItem.id);
                    $scope.selectedItem = selectedItem.id;
                };

                $scope.addFriend = function (item) {
                    console.log('add friend');
                    console.log(item);
                };
            }
        ]
    );
