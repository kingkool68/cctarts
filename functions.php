<?php
// Theme supports
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

function ccta_register_scripts_styles() {
	global $wp_scripts;
	global $wp_styles;

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv-printshiv.min.js', array(), '3.7.3' );
	$wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'global', get_template_directory_uri() . '/js/global.js', array( 'jquery' ), null );

	// Styles
	wp_enqueue_style( 'ccta', get_template_directory_uri() . '/css/ccta.css', array(), null, 'all' );
	wp_enqueue_style( 'ccta-print', get_template_directory_uri() . '/css/print.css', array('ccta'), null, 'print' );
}
add_action( 'wp_enqueue_scripts', 'ccta_register_scripts_styles' );

function ccta_page_title() {
	global $wp_query;
	$title = '';
	if( is_singular() ) {
		$post = get_post();
		$title = $post->post_title;
	}

	if( is_tax( 'programs' ) ) {
		$title = $wp_query->queried_object->name . ' Program';
		if( $wp_query->queried_object->count > 1 ) {
			$title .= 's';
		}
	}

	echo wptexturize( $title );
}

function ccta_svg_icon( $name = '' ) {
	if( !$name ) {
		return;
	}

	echo '<svg class="icon icon-' . $name . '"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-' . $name . '"></use></svg>';
}

include 'functions/programs.php';
include 'functions/nav.php';
include 'functions/shortcodes.php';
