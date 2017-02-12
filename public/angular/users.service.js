/**
 * Created by MagnusPoppe on 23/01/2017.
 */

angular
    .module('prosjektWeb')
    .service("getUsers", function ( $http )
    {
        return {
            get: function() {
                return $http.get('api/users/get.php')
                       .then(function(result) {
                            return result.users;
                        }
                );
            }
        }
    });