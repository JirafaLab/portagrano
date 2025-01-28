<?php
/**
 * Template Name: Home2
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
				<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold cabecera-icono ico-ultimas-noticias">Últimas noticias</h2>
			</div>
			<div class="jky-display-flex seccion ultimas-noticias contenido">
				<div class="columna col-3-4">
<?php
	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios-home',-1);
	$indicebanners = 0;
/*
	echo "<pre>";
		var_dump($banners);
	echo "</pre>";
*/		
	// 1 - Últimas Noticias
$noticias_mostradas = array();
$query_noticias = new WP_Query(array( 
	'category__in' 		=> 1,
	'status'			=> 'published',
	'posts_per_page'	=> 3,
    'orderby' 			=> 'date',
    'order' 			=> 'DESC'
	));	

// The Loop
$contador	= 0;
$devolver 	= "";
while($query_noticias->have_posts() )
{
	$query_noticias->the_post();
	
	$clase="";
	$id		= get_the_ID();
	$noticias_mostradas[] = $id;
	$titulo = get_the_title();
	$fecha	= get_the_date("d F Y");
	$imagen	= get_the_post_thumbnail($id,'full');
	$enlace	= get_the_permalink();
	$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
	if($contador == 0)
	{
		$devolver .= '<div class="columna col-principal">';
			$devolver .= '<div class="caja-noticia orden-'.$contador.'">';
				$devolver .= '<div class="foto-noticia">'.'<a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$imagen.'</a>'.'</div>';
				$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
				$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';
			$devolver .= '</div>';	
		$devolver .= '</div> <!-- col-principal -->';
	}
	else
	{
	if($contador == 1)
		$devolver .= '<div class="columna col-secundaria">';
			$devolver .= '<div class="caja-noticia orden-'.$contador.'">';
		if($contador==1)
			$devolver .= '<div class="foto-noticia">'.'<a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$imagen.'</a>'.'</div>';
			
			$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
			$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';		
		$devolver .= '</div>';
	if($contador == 2)
		$devolver .= '</div> <!-- col-secundaria -->';
	}
	$contador++;
}
wp_reset_postdata();
echo $devolver;
?>
				</div> <!-- .columna.col-3-4 -->
				
				<div class="columna col-1-4 jky-display-flex banners">
					<?php
						$bannerfijo = dameArrayBanners('fijo-1',1);
						pintaAnuncio($bannerfijo, 0);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
					?>
				</div>
				<div class="columna col-1-1 jky-display-flex banners horizontales">
					<?php 
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
<!-- FIN Ultimas -->
<!-- Descatamos
			<div class="cabecera">
				<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold cabecera-icono ico-destacamos">Destacamos...</h2>
			</div>
 -->			
			<div class="jky-display-flex seccion noticias-destacadas contenido">
				<div class="columna col-3-4">
<?php
	// 101 - Destacadas
$query_noticias = new WP_Query(array( 
	'category__in' 		=> 1,
	'status'			=> 'published',
	'posts_per_page'	=> 2,
    'orderby' 			=> 'date',
    'order' 			=> 'DESC',
    'post__not_in'     	=> $noticias_mostradas // Excluye las noticias ya mostradas
	));	

// The Loop
// $contador	= 0;
$devolver 	= "";
while($query_noticias->have_posts() )
{
	$query_noticias->the_post();
	
	$clase="";
	$id		= get_the_ID();
	$noticias_mostradas[] = $id;
	$titulo = get_the_title();
	$fecha	= get_the_date("d F Y");
	$imagen	= get_the_post_thumbnail($id,'full');
	$enlace	= get_the_permalink();
	$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
	$html_a = '<a class="ver-mas" href="'.$enlace.'" '.$enlace_title.'>Leer más</a>';
	
	$devolver .= '<div class="columna col-mitad">';
		$devolver .= '<div class="caja-noticia destacada orden-'.$contador.'">';
			$devolver .= '<div class="foto-noticia">'.'<a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$imagen.'</a>'.'</div>';
			$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';
			$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
			$devolver .= '<div class="texto-noticia">';
				$content = wp_strip_all_tags(get_the_content());
				$content = strip_shortcodes($content);
				$devolver .= wp_trim_words($content, 30, ' [...]');
			$devolver .= '</div>';
			$devolver .= $html_a;
		$devolver .= '</div>';	
	$devolver .= '</div> <!-- col-mitad -->';
	$contador++;
}
wp_reset_postdata();
echo $devolver;
?>
				</div> <!-- .columna.col-3-4 -->
				
				<div class="columna col-1-4 jky-display-flex">
					<?php $indicebanners = pintaAnuncio($banners, $indicebanners); ?>
					<div class="cabecera otras-noticias">
						<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">Otras Noticias</h2>
					</div>
					<div class="contenido">
<?php
	// 125 - Otras destacadas
$query_noticias = new WP_Query(array( 
	'category__in' 		=> 1,
	'status'			=> 'published',
	'posts_per_page'	=> 2,
    'orderby' 			=> 'date',
    'order' 			=> 'DESC', 
    'post__not_in'     	=> $noticias_mostradas // Excluye las noticias ya mostradas
	));	

// The Loop
$contador	= 0;
$devolver 	= "";
while($query_noticias->have_posts() )
{
	$query_noticias->the_post();
	
	$clase="";
	$id		= get_the_ID();
	$noticias_mostradas[] = $id;
	$titulo = get_the_title();
	$fecha	= get_the_date("d F Y");
	$enlace	= get_the_permalink();
	$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
	
	
	$devolver .= '<div class="caja-noticia sidebar orden-'.$contador.'">';
		$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
		$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';
	$devolver .= '</div>';
	
	$contador++;
}
wp_reset_postdata();
echo $devolver;
?>						
					</div>
				</div>
				<div class="columna col-1-1 jky-display-flex banners horizontales">
					<?php 
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
<!-- FIN Descatamos -->

<!-- Sección Home.3 -->
			<div class="jky-display-flex seccion noticias-a-pares contenido">
				<div class="columna col-3-4">
<?php
	// Sin filtro / limite 8
$query_noticias = new WP_Query(array(	
	'category__in' 		=> 1,
	'status'			=> 'published',
	'posts_per_page'	=> 8,
    'orderby' 			=> 'date',
    'order' 			=> 'DESC', 
    'post__not_in'     	=> $noticias_mostradas // Excluye las noticias ya mostradas
	));	

// The Loop
// $contador	= 0;
$devolver 	= "";
while($query_noticias->have_posts() )
{
	$query_noticias->the_post();
	
	$clase="";
	$id		= get_the_ID();
	$noticias_mostradas[] = $id;
	$titulo = get_the_title();
	$fecha	= get_the_date("d F Y");
	$enlace	= get_the_permalink();
	$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
	
	$devolver .= '<div class="columna col-mitad">';
		$devolver .= '<div class="caja-noticia a-pares orden-'.$contador.'">';
			$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
			$devolver .= '<div class="texto-noticia">';
			$content = wp_strip_all_tags(get_the_content());
			$content = strip_shortcodes($content);
			$devolver .= wp_trim_words($content, 30, ' [...]');
			$devolver .= '</div>';
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
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					
					$bannerfijo = dameArrayBanners('fijo-2',1);
					pintaAnuncio($bannerfijo, 0);
					$bannerfijo = dameArrayBanners('fijo-3',1);
					pintaAnuncio($bannerfijo, 0);
					$bannerfijo = dameArrayBanners('fijo-4',1);
					pintaAnuncio($bannerfijo, 0);
				?>
			</div>
			<div class="columna col-1-1 jky-display-flex banners">
				<?php 
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
					$indicebanners = pintaAnuncio($banners, $indicebanners);
				?>
			</div>
		</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->			
	</div>
		

	</main><!-- #main -->

<?php
get_footer();