/**
* tell directive to use content variable (@, =, &)
*/
angular.module('testApp')
.directive('postContent', function() {
    return {
        restrict: "E",
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/post-content.html',
        scope: {
            content: "@",
            image: "@",
            id: "@"
        }
    };
});