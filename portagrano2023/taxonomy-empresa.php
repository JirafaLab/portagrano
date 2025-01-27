<?php
/**
 * The template for displaying archive Empresa
 *
 */

get_header();

	$objeto = get_queried_object();
//	var_dump($objeto);
	$idempresa 	= $objeto->term_id;
	$nombre 	= $objeto->name;
	$descripcion= get_field('descripcion', 'empresa_' . $idempresa);
	$descripcion2=$objeto->description;
	$img		= get_field('logo_foto_empresa', 'empresa_' . $idempresa);
	$img_alt 	= $img['alt'];
	$img 		= $img['url'];
	

	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios',-1);
	$indicebanners = 0;
?>

	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejas();
?>
			<!-- Ultimas -->
			<div class="cabecera">
				<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">
				<?php 
					echo "Empresa: $nombre";
				?>
				</h2>
			</div>
			<div class="jky-display-flex seccion noticias-destacadas archive-noticias contenido">
				<div class="columna col-3-4 single-empresa">
<?php
	echo "<div class='single-empresa cajita-logo'>";
		echo "<img src='$img' alt='$img_alt'/>";
	echo "</div>";
	echo "<div class='single-empresa descripcion'>";
		echo $descripcion;
	echo "</div>";
	echo "<div class='single-empresa descripcion-2'>";
		echo $descripcion2;
	echo "</div>";
	
?>
				</div> <!-- .columna.col-3-4 -->
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$bannerfijo = dameArrayBanners('fijo-1',1);
						pintaAnuncio($bannerfijo, 0);
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
<!-- FIN Descatamos -->
<!-- Sección Home.3 -->
			<div class="jky-display-flex seccion noticias-a-pares contenido seccion-raya">
				<div class="columna col-3-4">
<?php
	
?>
				</div> <!-- .columna.col-3-4 -->				
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
/*
						while($indicebanners < count($banners))
						{
							$indicebanners = pintaAnuncio($banners, $indicebanners);
						}
						$bannerfijo = dameArrayBanners('fijo-2',1);
						pintaAnuncio($bannerfijo, 0);
						$bannerfijo = dameArrayBanners('fijo-3',1);
						pintaAnuncio($bannerfijo, 0);
						$bannerfijo = dameArrayBanners('fijo-4',1);
						pintaAnuncio($bannerfijo, 0);
*/
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->	
		</div>
	</main><!-- #main -->
<?php	
get_footer();