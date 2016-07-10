<?php

class AuthorRoute extends WP_REST_Controller
{

    protected $namespace = 'custom/v2';
    protected $base = 'author';

    function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/'. $this->base .'/(?P<id>[\d]+)', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array($this, 'get_item'),
                //'permission_callback' => array($this, 'get_items_permissions_check'),
            ),
        ));
    }

    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_item($request)
    {
        $items = get_posts(array(
            'author' => $request['id'],
        ));

        if ( empty( $items ) ) {
            return new WP_Error( 'awesome_no_author', 'Invalid author', array( 'status' => 404 ) );
        }

        $posts = array();
        foreach ( $items as $post ) {
            $data = $this->prepare_item_for_response( $post, $request );
            $posts[] = $this->prepare_response_for_collection( $data );
        }

        $response = rest_ensure_response( $posts );

        return $response;
        //return new WP_REST_Response( $items, 200 );
    }

    /**
     * Prepare a single post output for response
     *
     * @param WP_Post $post Post object
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response $data
     */
    public function prepare_item_for_response( $post, $request ) {
        $GLOBALS['post'] = $post;
        setup_postdata( $post );

        // Base fields for every post
        $data = array(
            'id'             => $post->ID,
            'date'           => $this->prepare_date_response( $post->post_date_gmt, $post->post_date ),
            'date_gmt'       => $this->prepare_date_response( $post->post_date_gmt ),
            'slug'           => $post->post_name,
            'status'         => $post->post_status,
            'link'           => get_permalink( $post->ID ),
            'author'         => (int) $post->post_author,
            'author_nicename'=> get_the_author(),
            'featured_image' => $this->prepare_featured_image( $post->ID ),
            'title'          => array(
                                    'rendered' => get_the_title( $post->ID ),
                                ),
            'content'        => array(
                                    'rendered' => apply_filters( 'the_content', $post->post_content ),
                                ),
            'excerpt'        => array(
                                    'rendered' => $this->prepare_excerpt_response( $post->post_excerpt ),
                                ),
        );

        // Wrap the data in a response object
        $data = rest_ensure_response( $data );

        $data->add_links( $this->prepare_links( $post ) );

        return apply_filters( 'rest_prepare'. $this->base, $data, $post, $request );
    }

    /**
     * Check the post_date_gmt or modified_gmt and prepare any post or
     * modified date for single post output.
     *
     * @param string       $date_gmt
     * @param string|null  $date
     * @return string|null ISO8601/RFC3339 formatted datetime.
     */
    protected function prepare_date_response( $date_gmt, $date = null ) {
        if ( '0000-00-00 00:00:00' === $date_gmt ) {
            return null;
        }

        if ( isset( $date ) ) {
            return rest_mysql_to_rfc3339( $date );
        }

        return rest_mysql_to_rfc3339( $date_gmt );
    }

    /**
     * Check the post excerpt and prepare it for single post output
     *
     * @param string       $excerpt
     * @return string|null $excerpt
     */
    protected function prepare_excerpt_response( $excerpt ) {
        if ( post_password_required() ) {
            return __( 'There is no excerpt because this is a protected post.' );
        }

        $excerpt = apply_filters( 'the_excerpt', apply_filters( 'get_the_excerpt', $excerpt ) );

        if ( empty( $excerpt ) ) {
            return '';
        }

        return $excerpt;
    }

    /**
     * Prepare Featured image
     *
     * @param integer $postId
     * @return array
     */
    protected function prepare_featured_image( $postId ) {
        $data = [];
        $thumbnailId = (int) get_post_thumbnail_id( $postId );
        $data['full'] = wp_get_attachment_image_src( $thumbnailId, 'full' );
        $data['thumbnail'] = wp_get_attachment_image_src( $thumbnailId );

        return $data;
    }

    /**
     * Prepare links for the request.
     *
     * @param WP_Post $post Post object.
     * @return array Links for the given post.
     */
    protected function prepare_links( $post ) {
        $base = $this->namespace. '/'. $this->base;

        // Entity meta
        $links = array(
            'self' => array(
                'href' => rest_url( trailingslashit( $base ) . $post->post_author ),
            ),
            'collection' => array(
                'href' => rest_url( $base ),
            ),
        );

        if ( ( in_array( $post->post_type, array( 'post', 'page' ) ) || post_type_supports( $post->post_type, 'author' ) )
            && ! empty( $post->post_author ) ) {
            $links['author'] = array(
                'href'       => rest_url( '/wp/v2/users/' . $post->post_author ),
                'embeddable' => true,
            );
        };

        if ( ! in_array( $post->post_type, array( 'attachment', 'nav_menu_item', 'revision' ) ) ) {
            $attachments_url = rest_url( 'wp/v2/media' );
            $attachments_url = add_query_arg( 'post_parent', $post->ID, $attachments_url );
            $links['http://v2.wp-api.org/attachment'] = array(
                'href'       => $attachments_url,
                'embeddable' => true,
            );
        }

        return $links;
    }


    /**
     * Check if a given request has access to get items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_items_permissions_check( $request )
    {
        //return true; <--use to make readable by all
        return current_user_can( 'edit_something' );
    }
}