<?php
include __DIR__ . DIRECTORY_SEPARATOR .'AuthorRoute.php';
include __DIR__ . DIRECTORY_SEPARATOR .'GetIdRoute.php';

class AngularApp
{
    function __construct()
    {
        add_action('wp_head', array($this, 'assetsHeader'), 1);
        add_action('wp_enqueue_scripts', array( $this, 'assets'), 101);
        // Here we add featured image to /post response
        add_action('rest_api_init', array($this, 'post_register_featured_image'));
        new AuthorRoute();
        new GetIdRoute();
    }

    public function assets()
    {
        // Bootstrap
        wp_enqueue_style('bootstrap_css', get_template_directory_uri().'/assets/angular-app/assets/bootstrap.min.css', false, null);

        // App files
        wp_enqueue_script('angular-app', get_template_directory_uri() . '/assets/angular-app/app.js', [], null, true);
        wp_enqueue_script('angular-app-routs', get_template_directory_uri() . '/assets/angular-app/app-routs.js', [], null, true);
        // Controllers
        wp_enqueue_script('angular-app-authors-controller', get_template_directory_uri() . '/assets/angular-app/controllers/authors-controller.js', [], null, true);
        wp_enqueue_script('angular-app-post-controller', get_template_directory_uri() . '/assets/angular-app/controllers/post-controller.js', [], null, true);
        wp_enqueue_script('angular-app-blog-controller', get_template_directory_uri() . '/assets/angular-app/controllers/blog-controller.js', [], null, true);
        wp_enqueue_script('angular-app-allpostid-controller', get_template_directory_uri() . '/assets/angular-app/controllers/allpostid-controller.js', [], null, true);
        // Directives
        wp_enqueue_script('angular-app-post-content-directives', get_template_directory_uri() . '/assets/angular-app/directives/post-content.js', [], null, true);
        wp_enqueue_script('angular-app-nav-links-directives', get_template_directory_uri() . '/assets/angular-app/directives/nav-links.js', [], null, true);
        wp_enqueue_script('angular-app-active-link-directives', get_template_directory_uri() . '/assets/angular-app/directives/active-link.js', [], null, true);
        // Service, Filters
        wp_enqueue_script('angular-app-post-services', get_template_directory_uri() . '/assets/angular-app/services/post.js', [], null, true);
        wp_enqueue_script('angular-app-sanitize-filter', get_template_directory_uri() . '/assets/angular-app/filters/sanitize.js', [], null, true);
    }

    public function assetsHeader()
    {
        wp_enqueue_script('angular', get_template_directory_uri() . '/assets/angular-app/assets/angular.min.js', [], null, false);
        wp_enqueue_script('angular-route', get_template_directory_uri() . '/assets/angular-app/assets/angular-route.min.js', ['angular'], null, false);
        wp_enqueue_script('angular-resource', get_template_directory_uri() . '/assets/angular-app/assets/angular-resource.min.js', ['angular'], null, false);
    }

    public function post_register_featured_image()
    {
        register_api_field( 'post',
            'featured_image',
            array(
                'get_callback'    => array($this, 'post_get_fetured_image'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }

    public function post_get_fetured_image($object, $field_name, $request)
    {
        $data = [];
        $thumbnailId = (int) get_post_thumbnail_id( $object[ 'id' ] );
        $data['full'] = wp_get_attachment_image_src( $thumbnailId, 'full' );
        $data['thumbnail'] = wp_get_attachment_image_src( $thumbnailId );

        return $data;
    }
}

new AngularApp();
