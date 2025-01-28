<?php
/**
 * Template Name: Crear / Editar semilla
*/

get_header();

$user_data = userEsAdmin(); // Obtienes los datos del usuario
if ($user_data && array_intersect($user_data[2], ['administrator', 'editor_de_variedades'])) {
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
}
else
{
	wp_redirect(home_url());
}
get_sidebar();
get_footer();
