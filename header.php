<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="date" content="<?php echo date('Ymd',strtotime($post->post_date)); ?>">
<meta name="viewport" content="width=device-width">
<link href="<?php echo get_template_directory_uri();?>/favicon.ico" rel="shortcut icon" type="image/x-icon">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>">
<?php wp_head(); ?>
</head>
<body <?php echo body_class(); ?>>
	<?php include 'svg/social-media-icons.svg'; ?>

<header>
	<a href="<?php echo esc_attr( get_site_url() ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/ccta-logo.png" class="logo"></a>

	<?php
	$args = array(
		'theme_location'  => 'main',
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);
	?>
	<nav><?php wp_nav_menu( $args ); ?></nav>
</header>

<?php
$featured_image_class = 'no-featured-image';
$featured_image = '';

$attachment_id = get_post_thumbnail_id();
$src = wp_get_attachment_image_src( $attachment_id, 'full' );
if( isset( $src[0] ) && !empty( $src[0] ) ) {
	$featured_image_class = '';
	$featured_image = '<img src="' . $src[0] . '">';
}
?>

<div class="featured-image <?php echo $featured_image_class; ?>">
	<?php echo $featured_image; ?>

	<h1 class="page-title"><?php ccta_page_title(); ?></h1>
</div>
