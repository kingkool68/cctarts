<?php
global $wp_query;
get_header();
?>
<main role="main" id="main">
	<?php if( $description = $wp_query->queried_object->description ) {
		echo '<article class="term-description">';
		echo wpautop( wptexturize( $description ) );
		echo '</article>';
	} ?>
	
	<?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

		<?php get_template_part( 'loop', 'program' ); ?>

		<?php
		endwhile;
	endif;
?>
</main>
<?php get_footer();
