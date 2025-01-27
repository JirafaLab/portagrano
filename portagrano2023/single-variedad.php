<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package portagrano2023
 */

get_header();

$id 	= get_the_ID();
//wp_redirect(home_url('/crear-editar-semilla/?id_semilla='.$id));

?>
	<main id="primary" class="site-main container con-orejas">
<?php 
	ponOrejas();
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'semilla' );
		endwhile; // End of the loop.
		?>
	</main><!-- #main -->
<?php
get_sidebar();
get_footer();