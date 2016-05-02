<?php
/* Add support for featured images */
add_theme_support( 'post-thumbnails' );

/* Disable WordPress Admin Bar */
add_filter('show_admin_bar', '__return_false');