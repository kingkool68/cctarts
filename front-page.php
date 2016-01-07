<?php get_header(); ?>
<main role="main" id="main">
	<?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>
		<article>
			<?php the_content(); ?>
		</article>

		<?php
        if( function_exists('get_gizmos') ) {
            if( $gizmos = get_gizmos('CCTAHomepageBoxes') ) {
                echo '<section class="homepage-boxes">';
                render_gizmo('CCTAHomepageBoxes');
                render_gizmo('CCTAHomepageBoxes');
                render_gizmo('CCTAHomepageBoxes');
                echo '</section>';
            }
        }
		endwhile;
	endif;
?>
</main>
<?php get_footer();
