/**
* keep using of this keyword here, just as an example, but have to use alias controllerAs: 'postCtrl'
* as well as need to use that alias inside of template to access the post variable, like: postCtrl.post
* for better $scope example check AuthorsController
*
* routeParams injected to gain access to the post's id
*/
angular.module('testApp')
.controller('PostController', ['$http', '$routeParams', function($http, $routeParams) {
    var self = this; // may be replaced with $scope

    $http.get(DEFAULT_REQUEST_URL_BASE + '/posts/' + $routeParams.id)
    .success(function(data){
        self.post = data;
    });

}]);