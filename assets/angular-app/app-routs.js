angular.module('testApp')
.config(function($routeProvider) {

    $routeProvider.when('/authors', {
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/authors.html',
        controller: 'AuthorsController'
    })

    .when('/all-post-ids', {
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/all-post-ids.html',
        controller: 'AllpostidController'
    })

    .when('/blog', {
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/blog.html',
        controller: 'BlogController',
    })

    .when('/blog/page/:page', {
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/blog.html',
        controller: 'BlogController'
    })

    .when('/post/:id', {
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/post.html',
        controller: 'PostController',
        controllerAs: 'postCtrl'
    })

    .when('/', {
        templateUrl: WPTemplateDir + '/lib/angular-app/templates/home.html'
    })

    .otherwise({ redirectTo: '/' });

});