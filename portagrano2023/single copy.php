<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package portagrano2023
 */

get_header();

	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios-noticias',-1);
	$indicebanners = 0;

while ( have_posts() ) :
	the_post();
	$id		= get_the_ID();
	$titulo = get_the_title();
	$fecha	= get_the_date("d F Y");
	
	$imagen	= get_the_post_thumbnail($id,'full');
	// $texto	= wpautop(get_the_content());
	$texto	= wpautop(get_the_content());
	$enlace	= get_the_permalink();
	$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
endwhile; // End of the loop.
?>
	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejas();
?>
			<div class="cabecera">
				<h2 class="fuente-tipo-mp fuente-size-18">
				<?php
					$titulo = get_the_title($id);
					$home	= get_home_url();
					echo "<a href='$home'>Inicio</a>  » <a href='$home/noticias'>Noticias</a>  » <strong>$titulo</strong>";
				?>	
				</h2>
			</div>
			<div class="jky-display-flex seccion noticias-destacadas contenido">
				<div class="columna col-3-4">
<?php
					echo '<div class="foto-noticia single">'.$imagen.'</div>';
					echo '<div class="fecha-noticia single">'.$fecha.'</div>';
					echo '<div class="titular-noticia single">'.'<h3>'.$titulo.'</h3>'.'</div>';
					echo '<div class="texto-noticia">'.$texto.'</div>';
					echo do_shortcode('[Sassy_Social_Share]');	
?>
				</div> <!-- .columna.col-3-4 -->
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
						$bannerfijo = dameArrayBanners('fijo-1',1);
						pintaAnuncio($bannerfijo, 0);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						$indicebanners = pintaAnuncio($banners, $indicebanners);
						helperArchivoNoticias("Otras Noticias");
						$indicebanners = pintaAnuncio($banners, $indicebanners);
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
					<div class="cabecera">
						<h2 class="fuente-tipo-ff fuente-size-18 fuente-estilo-bold">Otras noticias</h2>
					</div>
<?php
	// Sin filtro / limite 4
	$query_noticias = new WP_Query(array(	
		'posts_per_page'	=> 4,
		'orderby'			=> 'published',
		'order'				=> 'DESC',
		));	
	
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
			$devolver .= '<div class="caja-noticia a-pares orden-2">';
				$devolver .= '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
				$devolver .= '<div class="texto-noticia">'.$texto.'</div>';
				$devolver .= '<div class="fecha-noticia">'.$fecha.'</div>';
			$devolver .= '</div>';	
		$devolver .= '</div> <!-- col-mitad -->';
		$contador++;
	}
	wp_reset_postdata();
	echo $devolver;
	
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
	?>
				</div> <!-- .columna.col-3-4 -->
				
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
						//while($indicebanners < count($banners))
						while($indicebanners < 6)
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