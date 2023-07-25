<?php
/**
 * Register custom Segment for manual notification.
 */
 
namespace BuddyBossApp\Custom;
 
use BuddyBossApp\UserSegment\SegmentsAbstract;
 
/**
 * Class Book
 * @package BuddyBossApp\Menus
 */
class BookSegment extends SegmentsAbstract {
 
    /**
     * BookSegment constructor.
     */
    public function __construct() {
 
        $this->add_group( 'books', __( "Books", "buddyboss-app" ) );
 
        $this->add_filter( "books", "user_books", array( "book_select" ), array(
            'label' => __( 'Book Authors', 'buddyboss-app' ),
        ) );
 
        $book_options = array();
        $book_query   = new \WP_Query( array(
            'post_type'   => 'book ',
            'fields'      => 'ids',
            'nopaging'    => true,
            'orderby'     => 'name',
            'order'       => 'asc',
            'post_status' => array( 'publish' ),
        ) );
        if ( $book_query->have_posts() ) {
            foreach ( $book_query->posts as $book_id ) {
                $book_options[ $book_id ] = get_the_title( $book_id );
            }
        }
        $this->add_field( "book_select", "Checkbox", array(
            "options"       => $book_options,
            "multiple"      => true,
            "empty_message" => __( "No books found.", "buddyboss-app" ),
        ) );
 
        $this->load();
    }
 
    /**
     * @param $user_ids
     *
     * @return array
     */
    function filter_users( $user_ids ) {
        $filter    = $this->get_filter_data_value( 'filter' );
        $book_ids  = (array) $this->get_filter_data_value( 'book_select' );
        $_user_ids = array();
 
        switch ( $filter ) {
            case 'books_user_books':
                // Write logic to get user ids based on selected value.
                // Here I'm simply return books author
                foreach ( $book_ids as $book_id ) {
                    $_user_ids[] = get_post_field( 'post_author', $book_id );
                }
        }
 
        if ( ! empty( $_user_ids ) ) {
            return array_merge( $user_ids, $_user_ids );
        }
 
        return $user_ids;
    }
 
    /**
     *
     */
    function render_script() {
        // TODO: Implement render_script() method.
    }
}