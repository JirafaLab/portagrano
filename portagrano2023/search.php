<?php
/**
 * The template for displaying search results pages
 *
 */

get_header();

	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios',-1);
	$indicebanners = 0;

	$exluidas=array();
	
	$args = array(
	    'posts_per_page'=> 4,
	    'post_type'     => 'post',
	    'post_status'   => 'publish',
	    'orderby'       => 'date',
	    'order'         => 'DESC',
	    's'             => get_search_query() // Agregar la consulta de búsqueda aquí
	);
	
?>

	<main id="primary" class="site-main">
		<div class="container">
			<!-- Ultimas -->
			<div class="cabecera">
				<h2 class="fuente-tipo-ff fuente-size-18 fuente-estilo-bold">
				<?php 
					printf( esc_html__( 'Resultados de búsqueda para : %s', 'portagrano2023' ), '<span>' . get_search_query() . '</span>' );
				?>
				</h2>
			</div>
			<div class="jky-display-flex seccion noticias-destacadas archive-noticias contenido">
				<div class="columna col-3-4">
<?php
	// Sacaremos las 4 ultimas noticias
	// las guardamos en un array para excluirlas luego
	$query_noticias = new WP_Query($args);
	
	// The Loop
	// $contador	= 0;
	$devolver 	= "";
	while($query_noticias->have_posts() )
	{
		$query_noticias->the_post();
		
		$clase="";
		$id		= get_the_ID();
		$exluidas[] = $id;
		$titulo = get_the_title();
		$fecha	= get_the_date("d F Y");
		$texto	= get_the_excerpt();
		$imagen	= get_the_post_thumbnail($id,'full');
		$enlace	= get_the_permalink();
		$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
		$html_a = '<a class="ver-mas" href="'.$enlace.'" '.$enlace_title.'>Leer más</a>';
		
		$devolver .= '<div class="columna col-mitad">';
			$devolver .= '<div class="caja-noticia destacada orden-'.$contador.'">';
				$devolver .= '<div class="foto-noticia">'.'<a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$imagen.'</a>'.'</div>';
				$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';
				$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
				$devolver .= '<div class="texto-noticia">'.$texto.'</div>';
				$devolver .= $html_a;
			$devolver .= '</div>';	
		$devolver .= '</div> <!-- col-mitad -->';
		$contador++;
	}
	wp_reset_postdata();
	echo $devolver;
?>
				</div> <!-- .columna.col-3-4 -->
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$bannerfijo = dameArrayBanners('fijo-1',1);
						pintaAnuncio($bannerfijo, 0);
						helperArchivoNoticias("Otras Noticias");
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
<!-- FIN Descatamos -->
<!-- Sección Home.3 -->
			<div class="jky-display-flex seccion noticias-a-pares contenido seccion-raya">
				<div class="columna col-3-4">
<?php
	// Sin filtro / limite 8
	$args = array(
		'posts_per_page'	=> -1,
	    'post_type' 		=> 'post',
	    'post_status' 		=> 'publish',
	    'orderby' 			=> 'date',
	    'order' 			=> 'DESC',
	    'post__not_in'		=> $exluidas,
	    's'             => get_search_query() // Agregar la consulta de búsqueda aquí
	);		
	$query_noticias = new WP_Query($args);	
	
	// The Loop
	// $contador	= 0;
	$devolver 	= "";
	while($query_noticias->have_posts() )
	{
		$query_noticias->the_post();
		
		$clase="";
		$id		= get_the_ID();
		$exluidas[] = $id;
		$titulo = get_the_title();
		$fecha	= get_the_date("d F Y");
		$texto	= get_the_excerpt();
		$enlace	= get_the_permalink();
		$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
		
		$devolver .= '<div class="columna col-mitad">';
			$devolver .= '<div class="caja-noticia a-pares orden-'.$contador.'">';
				$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
				$devolver .= '<div class="texto-noticia">'.$texto.'</div>';
				$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';
			$devolver .= '</div>';	
		$devolver .= '</div> <!-- col-mitad -->';
		$contador++;
	}
	wp_reset_postdata();
	echo $devolver;
	?>
				</div> <!-- .columna.col-3-4 -->
				
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
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
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->	
		</div>
	</main><!-- #main -->
<?php
get_footer();