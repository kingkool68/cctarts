<?php
/* Menus */
register_nav_menus( array(
	'main' => 'Main',
) );

function ccta_nav_menu_css_class( $class, $item, $args ){
	$new_class = array();

	// echo '<pre>';
	// var_dump( $item );
	// echo '</pre>';
	if( in_array( 'menu-item-has-children', $item->classes ) ) {
		$new_class[] = 'has-children';
	}
	if( $item->menu_item_parent === '0' ) {
		$new_class[] = 'top-level';
	}

	return $new_class;
}
add_filter( 'nav_menu_css_class' , 'ccta_nav_menu_css_class', 10, 3 );

function ccta_nav_menu_item_id( $id ) {
	return '';
}
add_filter( 'nav_menu_item_id', 'ccta_nav_menu_item_id' );
