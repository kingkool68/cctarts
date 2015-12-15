<?php get_header(); ?>
<main role="main" id="main">
	<?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

		<?php get_template_part( 'loop', 'program' ); ?>

		<?php
		endwhile;
	endif;
?>
</main>
<?php get_footer();
