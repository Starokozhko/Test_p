<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>
<!-- BEGIN of 404 page -->
	<div class="row columns text-center not-found">
		<h1><?php _e('404: Page Not Found', 'foundation'); ?></h1>
		<h3><?php _e('Keep on looking...', 'foundation'); ?></h3>
		<p><?php printf(__('Double check the URL or head back to the <a class="label" href="%1s">HOMEPAGE</a>', 'foundation'), get_bloginfo('url')); ?></p>
	</div>
<!-- END of 404 page -->
<?php get_footer(); ?>