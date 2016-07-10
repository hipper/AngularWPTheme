/**
* use $scope here instead of this, so no need to use controller alias (controllerAs) in app-routs.js
* as well as I can directly access posts variable, instead of using authorCtrl.posts
*/
angular.module('testApp')
.controller('AuthorsController', function($scope, $http) {

    $http.get(REQUEST_URL_BASE + '/author/1').success(function(data){
        $scope.posts = data;
    });

});