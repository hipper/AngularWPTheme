<?php

class GetIdRoute extends WP_REST_Controller
{

    protected $namespace = 'custom/v2';
    protected $base = 'all-post-ids';

    function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/'. $this->base .'/', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array($this, 'get_items'),
            ),
        ));
    }

    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_items( $request ) {
        $all_post_ids = get_posts(array(
            'numberposts' => -1,
            'post_type'   => 'post',
            'fields'      => 'ids',
        ));

        return new WP_REST_Response( $all_post_ids, 200 );
    }
}
