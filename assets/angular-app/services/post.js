angular.module('testApp')
.factory("Post", function PostFactory($http){
    return {
        all: function() {
            return $http.get(DEFAULT_REQUEST_URL_BASE + '/posts/');
        },
        paginated: function($paginatedPage) {
            return $http.get(DEFAULT_REQUEST_URL_BASE + '/posts/?page=' + $paginatedPage);
        }
    };
});