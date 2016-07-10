/**
* Menu active link
*/
angular.module('testApp')
.directive('activeLink', ['$location', function(location) {
    return {
        restrict: "A",
        link: function( scope, element, attrs, controller){
            var clazz = attrs.activeLink;
            var path = element.find('a').attr('href');
            path = path.substring(1); //hack because path does not return including hashbang
            scope.location = location;

            scope.$watch('location.path()', function (newPath) {
                if (path === newPath) {
                    element.addClass(clazz);
                } else {
                    if (path.length > 1 && newPath.indexOf(path) !=-1) {
                        element.addClass(clazz);
                    } else {
                        element.removeClass(clazz);
                    }
                }
            });
        }
    };
}]);