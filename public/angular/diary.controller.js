
angular
    .module('prosjektWeb',
    [
        'ngSanitize'
    ])
    .controller('diary', function( $scope, getPosts )
    {
        getPosts.get().then(function(data) {
            $scope.posts = data;
        });
    });
