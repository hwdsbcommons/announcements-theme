<?php
/* Add support for featured images */
add_theme_support( 'post-thumbnails' );

/* Disable WordPress Admin Bar */
add_filter('show_admin_bar', '__return_false');

/* Add support to allow slides to be unpublished https://github.com/humanmade/Unpublish */
$types = array( 'post', 'page', 'slides' );
foreach( $types as $type ) {
    add_post_type_support( $type, 'unpublish' );
}
