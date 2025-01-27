<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package portagrano2023
 */


$id		= get_the_ID();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="cabecera titulo-variedad">
		<?php the_title( '<h1 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">', '</h1>' ); ?>
	</div>
		<div class="variedad-especie">
			<?php
				$dato = get_post_meta($id,'nombre_cientifico',true);
				if(!empty($dato))
				{
					echo '<h2 class="titulo-tipo-2">Nombre científico</h2>';
					echo '<span>'.$dato.'</span>';
				}
				$dato = get_post_meta($id,'nombre_ingles',true);
				if(!empty($dato))
				{
					echo '<h2 class="titulo-tipo-2">Nombre en Inglés</h2>';
					echo '<span>'.$dato.'</span>';
				}
				$dato = get_post_meta($id,'enfermedad_codigo',true);
				if(!empty($dato))
				{
					echo '<h2 class="titulo-tipo-2">Código</h2>';
					echo '<span>'.$dato.'</span>';
				}				
			?>
		</div>
		<div class="variedad-descripcion">
			<h2 class='titulo-tipo-2'>Descripción</h2>
			<div>
			<?php
				$dato = get_post_meta($id,'descripcion',true);
				if(!empty($dato))
				{
					echo nl2br($dato);
				}
			?>
			</div>
		</div>	
	</div>	
	<footer class="entry-footer">
		<?php portagrano2023_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
