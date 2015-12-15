<?php  $index = $wp_query->current_post + 1; ?>
<article class="program <?php echo 'program-' . $index; ?>">
	<?php if( is_archive() ) { ?>
		<h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	<?php } ?>
	<?php the_content(); ?>

	<?php echo get_ccta_program_details(); ?>
</article>
