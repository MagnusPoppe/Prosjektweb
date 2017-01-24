/**
 * Created by MagnusPoppe on 23/01/2017.
 */

angular
    .module('prosjektWeb')
    .service("getPosts", function ( $http )
    {
        return {
            get: function() {
                //return the promise directly.
                return $http.get('api/diary/get.php')
                    .then(function(result) {
                        //resolve the promise as the data
                        return result.data;
                    });
            }
        }
    });