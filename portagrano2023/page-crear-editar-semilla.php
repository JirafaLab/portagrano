<?php
/**
 * Template Name: Crear / Editar semilla
*/

get_header();

if(!userEsAdmin([0]))
	wp_redirect(home_url());
?>
	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejas();
?>
		<?php
		$idsemilla = 0;
		if(isset($_GET['id_variedad']))
		{
			$idsemilla = $_GET['id_variedad'];
		}
		jky_semilla_frontend_funcion($idsemilla);
		?>
		</div>
	</main><!-- #main -->
<?php
get_sidebar();
get_footer();
