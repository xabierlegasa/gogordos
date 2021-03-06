angular.module('myapp.addFriend', [
    'ui.router'
])

    .controller('AddFriendController',
        [
            '$http',
            '$state',
            '$scope',
            '$location',
            '$localStorage',
            function ($http, $state, $scope, $location, $localStorage) {
                $scope.itemArray = [];
                $scope.selected = {};
                $scope.isValid = false;
                $scope.selectedItem = {};

                $scope.refreshUsers = function (term) {
                    if (term.length >= 2) {
                        $http({
                            method: 'GET',
                            url: '/api/users',
                            params: {terms: term}
                        }).success(function (data) {
                            var items = [];
                            for (i = 0; i < data.users.length; i++) {
                                items.push({id: data.users[i].username, name: data.users[i].username});
                            }
                            $scope.itemArray = items;
                        }).error(function (data, status, headers, config) {
                            console.log('error obtaining users');
                        });
                    }
                };

                $scope.itemSelected = function (selectedItem) {
                    $scope.selectedItem = selectedItem.id;
                };

                $scope.addFriend = function (item) {
                    $http({
                        method: 'POST',
                        url: '/api/users/addFriend',
                        data: {'username': item.id, 'jwt': $localStorage.jwt}
                    }).success(function (data) {
                        $scope.errorMessage = '';
                        $scope.successMessage = 'Añadido como amigo.';
                    }).error(function (data, status, headers, config) {
                        $scope.errorMessage = data.message;
                    });
                };

                var jwt = $localStorage.jwt;
                $http({
                    method: 'GET',
                    url: '/api/account',
                    params: {jwt: jwt}
                }).then(function (data) {
                    var username = data.data.user.username;

                    $http({
                        method: 'GET',
                        url: '/api/followers',
                        params: {'foo': 'bar', 'username': username}
                    }).then(function (data) {
                        $scope.users = data.data.users;
                    });
                });
            }
        ]
    );
