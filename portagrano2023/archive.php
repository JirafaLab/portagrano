<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package portagrano2023
 */

get_header();

	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios-noticias',-1);
	$indicebanners = 0;

	$exluidas=array();
	// Estamos buscando algo como el archivo?
	$year = get_query_var('year');
	$month = get_query_var('monthnum');
	$archivo_fechas = false; 
	
	if((!empty($year)) && (!empty($month)))
	{
		$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$mes	= $meses[$month];
		$titulo_seccion = "Archivo por fechas: $mes de $year";
		// Archivo por fechas
		$archivo_fechas = true;
		$args = array(
			'posts_per_page'	=> 4,
		    'post_type' 		=> 'post',
		    'post_status' 		=> 'publish',
		    'orderby' 			=> 'date',
		    'order' 			=> 'DESC',
		    'date_query' => array(
		        array(
		            'year' => $year,
		            'month' => $month,
		        ),
		    )
		);
	}
	else // Archivo principal
	{
		$titulo_seccion = "Últimas noticias";
		$args = array(
			'posts_per_page'=> 4,
		    'post_type' 	=> 'post',
		    'post_status' 	=> 'publish',
		    'orderby' 		=> 'date',
		    'order' 		=> 'DESC'
		);
	}
	
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
					echo $titulo_seccion;
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
						//$bannerfijo = dameArrayBanners('fijo-1',1);
						//pintaAnuncio($bannerfijo, 0);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
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
	if($archivo_fechas)
	{
		$args = array(
			'posts_per_page'	=> -1,
		    'post_type' 		=> 'post',
		    'post_status' 		=> 'publish',
		    'orderby' 			=> 'date',
		    'order' 			=> 'DESC',
		    'date_query' => array(
		        array(
		            'year' => $year,
		            'month' => $month,
		        ),
		    ),
		    'post__not_in'		=> $exluidas,
		);
	}
	else
	{
		$args = array(
			'posts_per_page'	=> 4,
		    'post_type' 		=> 'post',
		    'post_status' 		=> 'publish',
		    'orderby' 			=> 'date',
		    'order' 			=> 'DESC',
		    'post__not_in'		=> $exluidas,
		);		
	}
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
						/*
						while($indicebanners < count($banners))
						{
							$indicebanners = pintaAnuncio($banners, $indicebanners);
						}
						*/
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