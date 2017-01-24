/**
 * Created by MagnusPoppe on 16/01/2017.
 */
angular
    .module('prosjektWeb',
    [

    ])
    .controller('writeController', function( $scope, getPosts, getUsers )
    {
        getUsers.get().then(function(data) {
            console.log(data);
            $scope.users = data;
        });

        getPosts.get().then(function(data) {
            $scope.posts = data;
        });
    });
