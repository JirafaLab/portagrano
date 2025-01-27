<?php
/**
 * Template Name: Contacto
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejas();
?>					
<!-- Ultimas -->
			<div class="cabecera">
				<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">Contacto</h2>
			</div>
			<div class="jky-display-flex seccion">
				<div class="columna col-3-4 contacto contenido">
<?php
	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios',-1);
	$indicebanners = 0;

	echo do_shortcode('[contact-form-7 id="32841" title="Contacto Principal"]');
?>
				</div> <!-- .columna.col-3-4 -->
				
				<div class="columna col-1-4 jky-display-flex banners">
					<?php
						$bannerfijo = dameArrayBanners('fijo-1',1);
						pintaAnuncio($bannerfijo, 0);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
					?>
				</div>
				<div class="columna col-1-1 jky-display-flex banners">
					<?php 
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
<!-- FIN Ultimas -->
	</div>
		

	</main><!-- #main -->

<?php
get_footer();