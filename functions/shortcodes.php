<?php
function ccta_button_shortcode( $atts, $content = '' ) {
	if( !$content ) {
		return;
	}

	$defaults = array(
		'color' => '',
		'url' => '',
		'align' => 'center',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$href = $atts['url'];
	if( !$href ) {
		$href = '#';
	}

	$css_class = array( 'ccta-button' );
	$color = strtolower( $atts['color'] );
	$button_colors = array( 'red', 'yellow', 'blue' );
	if( in_array( $color, $button_colors) ) {
		$css_class[] = 'ccta-button-color-' . $color;
	}

	$align = strtolower( $atts['align'] );
	if( $align == 'left' || $align == 'right' ) {
		$css_class[] = 'ccta-button-aligned-' . $align;
	}

	$css_class = implode( ' ', $css_class);

	return '<a href="' . esc_url( $href ) . '" class="' . $css_class . '">' . $content . '</a>';
}
add_shortcode( 'button', 'ccta_button_shortcode' );
