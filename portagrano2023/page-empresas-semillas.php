<?php
/**
 * Template Name: Empresas Semillas
*/
get_header();
?>
	<main id="primary" class="site-main">
		<div class="container con-orejas jky-display-flex elementos-espaciados mosaico empresas">
<?php 
	ponOrejas();
?>
			<div class="cabecera">
				<h2 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">
				<?php 
					the_title();
				?>
				</h2>
			</div>
			<div class="seccion jky-display-flex elementos-espaciados mosaico empresas">
		<?php
			$terms = get_terms( array(
			    'taxonomy' => 'empresa',
			    'orderby' => 'name',
			    'order' => 'ASC',
			    'hide_empty' => false
			));
			foreach ( $terms as $term )
			{
				// var_dump($term);
			    $id 			= $term->term_id;
			    $nombre			= $term->name;
			    // $descripcion	= $term->description;
			    $descripcion= get_field('descripcion', 'empresa_' . $id);
			    $img			= get_field('logo_foto_empresa', 'empresa_' . $id);
			    if(!empty($img))
			    {
					$img_alt = $img['alt'];
					$img = $img['url'];
					echo "<div class='caja-empresas'>";
						// echo "<a class='intangible' href='$enlace'>";
						echo "<div class='cajita-logo'>";
							echo "<img src='$img' alt='$img_alt'/>";
						echo "</div>";
						echo "<div class='cajita-txt'>";
							// echo "<h4>$nombre</h4>";
							echo $descripcion;
						echo "</div>";
						// echo "</a>";
					echo "</div>";    
			    }				
			}
		?>
			</div><!-- .seccion -->
		</div>
	</main><!-- #main -->
<?php
get_sidebar();
get_footer();