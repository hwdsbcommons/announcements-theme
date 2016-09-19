<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/* Disable WordPress Admin Bar */
add_filter('show_admin_bar', '__return_false');

/* Add support to allow slides to be unpublished https://github.com/humanmade/Unpublish */
$types = array( 'post', 'page', 'slides' );
foreach( $types as $type ) {
    add_post_type_support( $type, 'unpublish' );
}

function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
}
add_action( 'admin_init', 'remove_dashboard_meta' );

/**
* Add the Announcements taxonomy to the Presentation Taxonomy Type, on the Slides CPT.
*
*/
    function set_default_object_terms( $post_id, $post ) {
        if ( 'publish' === $post->post_status && $post->post_type === 'slides' ) {
            $defaults = array(
                'presentation' => array( 'announcements' )
                );
            $taxonomies = get_object_taxonomies( $post->post_type );
            foreach ( (array) $taxonomies as $taxonomy ) {
                $terms = wp_get_post_terms( $post_id, $taxonomy );
                if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                    wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
                }
            }
        }
    }
    add_action( 'save_post', 'set_default_object_terms', 0, 2 );

function remove_menus(){
  if( !current_user_can('manage_options')){
  remove_menu_page( 'index.php' );				//Dashboard
  remove_menu_page( 'edit.php' );					//Posts
  remove_menu_page( 'upload.php' );				//Media
  remove_menu_page( 'edit-comments.php' );			//Comments
  remove_menu_page( 'profile.php' );				//Comments
  remove_menu_page( 'users.php' );				//Users
  remove_menu_page( 'tools.php' );				//Tools
  remove_menu_page( 'options-general.php' );		//Settings
} 
}
add_action( 'admin_menu', 'remove_menus' );


function remove_wp_nodes(){
  if( !current_user_can('manage_options')){
  global $wp_admin_bar;   
  $wp_admin_bar->remove_node( 'new-post' );
  $wp_admin_bar->remove_node( 'new-link' );
  $wp_admin_bar->remove_node( 'new-media' );
  $wp_admin_bar->remove_node('comments');
  $wp_admin_bar->remove_node('new-content');
}
}
add_action( 'admin_bar_menu', 'remove_wp_nodes', 999 );

// REMOVE POST META BOXES
function remove_my_post_metaboxes() {
if( !current_user_can('manage_options')){
remove_meta_box( 'presentationdiv','slide','side' ); // Author Metabox
remove_meta_box( 'pageparentdiv','slide','side' ); // Comments Status Metabox
remove_meta_box( 'slide-settings','slide','normal' ); // Comments Metabox
remove_meta_box( 'postimagediv','slide','side' ); // Custom Fields Metabox
}
}
add_action('do_meta_boxes','remove_my_post_metaboxes');