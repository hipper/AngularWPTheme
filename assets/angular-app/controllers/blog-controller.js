/**
* use $scope here instead of this, so no need to use controller alias (controllerAs) in app-routs.js
* as well as I can directly access posts variable, instead of using authorCtrl.posts
*/
angular.module('testApp')
.controller('BlogController', ['$scope', '$routeParams', 'Post', function($scope, $routeParams, Post) {

    if ($routeParams.page) {
        /** Pagination */
        Post.paginated($routeParams.page)
        .success(function(data, status, headers){
            $scope.posts = data;

            $scope.currentPage = parseInt($routeParams.page);
            $scope.totalPages = headers('X-WP-TotalPages');
        });
    } else {
        /** No Pagination */
        Post.all()
        .success(function(data, status, headers){
            $scope.posts = data;

            $scope.currentPage = 1;
            $scope.totalPages = headers('X-WP-TotalPages');
        });
    }

}]);