/**
* Paginator links
*/
angular.module('testApp')
.directive('navLinks', ['$routeParams', function($routeParams) {
    return {
        restrict: "E",
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/nav-links.html',
        link: function( scope, element, attrs){
            var currentPage = ( ! $routeParams.page ) ? 1 : parseInt( $routeParams.page );

            scope.prevLink = ( ! currentPage == 1 ) ? '#/blog/page/' + ( currentPage - 1 ) : '#/blog/';
            scope.nextLink = '#/blog/page/' + ( currentPage + 1 );
        }
        // controller: ['$scope', '$routeParams', function( $scope, $routeParams ){
    };
}]);