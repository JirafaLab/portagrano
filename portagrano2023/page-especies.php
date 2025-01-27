<?php
/**
 * Template Name: Especies de Semillas
*/

get_header();

	// Banners Rotatorios
//	$banners = dameArrayBanners('rotatorios-home',-1);
//	var_dump($banners);
	$indicebanners = 0;

?>

	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejasVademecum();
?>
			<!-- Ultimas -->
			<div class="cabecera jky-display-flex">
				<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">Catálogo de Especies</h2>
				<input 
					type="reset" 
					value="Búsqueda avanzada" 
					class="btn btn-reset btn-buscador" 
					onclick="window.location.href='<?php echo home_url() ?>/busqueda-avanzada/'"/>
			</div>
			<div class="jky-display-flex seccion noticias-destacadas archive-noticias contenido">
				<div class="columna col-3-4 lista-especies-az">
<?php
	$terms = get_terms( array(
	    'taxonomy' 		=> 'especie',
	    'orderby' 		=> 'name',
	    'order' 		=> 'ASC',
	    'hide_empty' 	=> false,
	    'parent' 		=> 0 // Obtener solo los términos principales
	));
	foreach ( $terms as $term ) {
		// var_dump($term);
	    $id 			= $term->term_id;
	    $nombre			= $term->name;
	    $enlace			= get_term_link($id, 'especie');
	    $imagen_especie = "";
	    if (get_field('imagen_especie', $term)) {
			$imagen_especie = get_field('imagen_especie', $term)['url'];
		}
		echo "<a class='intangible especie-az' href='$enlace'>";
			echo "<div class='especie-capa-new' style = 'background-image: url($imagen_especie)'>";
				echo "<h4>$nombre</h4>";
			echo "</div>";
		echo "</a>";
	}
?>
				</div> <!-- .columna.col-3-4 -->
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
						// $bannerfijo = dameArrayBanners('fijo-1',1);
						// pintaAnuncio($bannerfijo, 0);
						$bannerfijo = dameArrayBanners('fijo-vademecum',-1);
						pintaAnuncio($bannerfijo, 0);
						// $bannerfijo = dameArrayBanners('fijo-3',1);
						// pintaAnuncio($bannerfijo, 0);
						// $bannerfijo = dameArrayBanners('fijo-4',1);
						// pintaAnuncio($bannerfijo, 0);
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
		</div>
	</main><!-- #main -->
<?php
get_footer();