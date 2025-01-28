<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package portagrano2023
 */


$taxonomia = 'especie';
$id		= get_the_ID();

$especies_desordenadas		= get_the_terms($id,'especie');
if(empty($especies_desordenadas))
	$especies_desordenadas = array();
$especies = array();
sort_terms_hierarchically($especies_desordenadas, $especies );
$terminos = dameTerminosDeVariedad($especies);
if(!empty($terminos[0]))
	$termino = $terminos[0];

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="cabecera titulo-variedad">
		<?php 
			$terminos = empty($terminos)? 0 : $terminos;
			if($terminos[0] != null)
			{
				$termino = $terminos[0];
				
				$termino_nombre = get_term_field( 'name', $termino );
				$termino_enlace = get_term_link( $termino, $taxonomia);
				// echo "<a class ='enlace-clasificacion termino-1' href='$termino_enlace'>$termino_nombre</a>";
				echo "<a class ='enlace-clasificacion-test termino-1' href='$termino_enlace'>$termino_nombre</a>&nbsp;/&nbsp;";
				
				if($terminos[1] != null)
				{
					$termino = $terminos[1];
					$termino_nombre = get_term_field( 'name', $termino );
					$termino_enlace = get_term_link( $termino, $taxonomia);
					// echo "<a class ='enlace-clasificacion termino-2' href='$termino_enlace'>$termino_nombre</a>";
					echo "<a class ='enlace-clasificacion-test termino-2' href='$termino_enlace'>$termino_nombre</a>&nbsp;/&nbsp;";
					if($terminos[2] != null)
					{
						$termino = $terminos[2];						
						$termino_nombre = get_term_field( 'name', $termino );
						$termino_enlace = get_term_link( $termino, $taxonomia);
						// echo "<a class ='enlace-clasificacion termino-3' href='$termino_enlace'>$termino_nombre</a>";
						echo "<a class ='enlace-clasificacion-test termino-3' href='$termino_enlace'>$termino_nombre</a>&nbsp;/&nbsp;";
					}
				}
			}
			the_title( '<h1 class="fuente-tipo-mp fuente-size-18 fuente-estilo-bold">', '</h1>' ); 
		?>
	</div>
	<div class="cuerpo contenido-especie">
		<div>
			<!-- <h2 class='titulo-tipo-2'>Clasificación</h2> -->
			<!--
				<div>
				<?php
					/*
					$terminos = empty($terminos)? 0 : $terminos;
					if($terminos[0] != null)
					{
						$termino = $terminos[0];
						
						$termino_nombre = get_term_field( 'name', $termino );
						$termino_enlace = get_term_link( $termino, $taxonomia);
						echo "<a class ='enlace-clasificacion termino-1' href='$termino_enlace'>$termino_nombre</a>";
						
						if($terminos[1] != null)
						{
							$termino = $terminos[1];
							$termino_nombre = get_term_field( 'name', $termino );
							$termino_enlace = get_term_link( $termino, $taxonomia);
							echo "<a class ='enlace-clasificacion termino-2' href='$termino_enlace'>$termino_nombre</a>";
							if($terminos[2] != null)
							{
								$termino = $terminos[2];						
								$termino_nombre = get_term_field( 'name', $termino );
								$termino_enlace = get_term_link( $termino, $taxonomia);
								echo "<a class ='enlace-clasificacion termino-3' href='$termino_enlace'>$termino_nombre</a>";
							}
						}
					}
					*/
				?>
				</div>
			-->
			<?php
				// Características
				$dato = get_the_terms($id,'caracteristica');
				$cadena = "";
				if(!empty($dato))
				{
					foreach($dato as $caract)
					{
					/*
						$idcarac 	= $caract->term_id;
						if($enlace_especie != "")
							$enlace = $enlace_especie."?caracteristicas[]=$idcarac";
						else
							$enlace = get_home_url()."/vademecum-semillas/?caracteristicas[]=$idcarac";
					*/
							
						$enlace = "#";
						$nombre = $caract->name;
						$slug	= $caract->slug;
						//$cadena .= "<a class = 'enlace-caracteristicas car-$slug' href='$enlace'>$nombre</a>&nbsp;";
						$cadena .= "<a class = 'enlace-caracteristicas car-$slug'>$nombre</a>&nbsp;";
					}
					echo '<span class="venta-etiqueta caracteristica">';
						//echo '<span>Características</span>: ';
						echo $cadena;
					echo '</span>';
				}
			?>
		</div>
		<div class="variedad-descripcion jky-display-flex">
			<div class="columna variedad-clasificacion">
				<h2 class='titulo-tipo-2'>Descripción</h2>
			<?php
			$dato = apply_filters('the_content', get_post_meta($id,'informacion_extra',true));
			if(!empty($dato))
				echo $dato;
			?>
			<br/><br/>
			<!-- Enfermedades -->
			<?php
				// enf_resistencia_alta
				$dato = get_post_meta($id,'enf_resistencia_alta',true);
				$cadena = "";
				if(!empty($dato))
				{
					foreach($dato as $enf)
					{
						$codigo = get_post_meta($enf, 'enfermedad_codigo', true);
						$cadena .= "<a class = 'enlace-enfermedad intangible' onclick='dameDatosEnfermedad($enf)'>$codigo</a>, &nbsp;";
					}
					echo '<span class="venta-etiqueta enfermedades"><span>Resistencia Alta: </span>'.$cadena.'</span>';
				}
				// enf_resistencia_intermedia
				$dato = get_post_meta($id,'enf_resistencia_intermedia',true);
				$cadena = "";
				if(!empty($dato))
				{
					foreach($dato as $enf)
					{
						// $nombre = get_post_field( 'post_title', $enf );
						// $cadena .= "<a class = 'enlace-enfermedad intangible' onclick='dameDatosEnfermedad($enf)'>$nombre ($codigo)</a>, &nbsp;";
						$codigo = get_post_meta($enf, 'enfermedad_codigo', true);
						$cadena .= "<a class = 'enlace-enfermedad intangible' onclick='dameDatosEnfermedad($enf)'>$codigo</a>, &nbsp;";
					}
					echo '<span class="venta-etiqueta enfermedades"><span>Resistencia Intermedia: </span>'.$cadena.'</span>';
				}
				// enf_tolerancia
				$dato = get_post_meta($id,'enf_tolerancia',true);
				$cadena = "";
				if(!empty($dato))
				{
					foreach($dato as $enf)
					{
						// $nombre = get_post_field( 'post_title', $enf );
						// $cadena .= "<a class = 'enlace-enfermedad intangible' onclick='dameDatosEnfermedad($enf)'>$nombre ($codigo)</a>, &nbsp;";
						$codigo = get_post_meta($enf, 'enfermedad_codigo', true);
						$cadena .= "<a class = 'enlace-enfermedad intangible' onclick='dameDatosEnfermedad($enf)'>$codigo</a>, &nbsp;";
					}
					echo '<span class="venta-etiqueta enfermedades"><span>Tolerancia: </span>'.$cadena.'</span>';
				}				
			?>
			</div>
			<div class="columna variedad-fotografía">
				<!-- <h2 class='titulo-tipo-2'>Fotografía</h2> -->
				<div>
					<?php 
						$thumbnail_html = get_the_post_thumbnail(get_the_ID(), 'full');
						if ($thumbnail_html) {
							// Agregar el atributo onclick manualmente
							echo str_replace('<img', '<img onclick="dameImagenAmpliada(this)" ', $thumbnail_html);
						}
						$imagen_extra = get_field('imagen_2');
						if(!empty($imagen_extra))
						{
							$image_url = $imagen_extra['url'];
							echo "<img src = '$image_url' onclick='dameImagenAmpliada(this)'/>";
						}

						$imagen_extra = get_field('imagen_3');
						if(!empty($imagen_extra))
						{
							$image_url = $imagen_extra['url'];
							echo "<img src = '$image_url' onclick='dameImagenAmpliada(this)'/>";
						}

						$imagen_extra = get_field('imagen_4');
						if(!empty($imagen_extra))
						{
							$image_url = $imagen_extra['url'];
							echo "<img src = '$image_url' onclick='dameImagenAmpliada(this)'/>";
						}
					?>
				</div>
			</div>
		</div>
		<div class="variedad-final jky-display-flex">
			<div class="variedad-especie">
			<?php
			// Empresas
			$dato = get_the_terms($id,'empresa');
			$cadena = "";
			if(!empty($dato))
			{
				foreach($dato as $empresa)
				{
					$enlace			= get_term_link($empresa);
					$nombre			= $empresa->name;
					$slug			= $empresa->slug;
					$empresa_id		= $empresa->term_id;
					$logotipo		= get_field('logo_foto_empresa', $empresa);
					$logotipo_html	= '';
					if($logotipo) {
						$logotipo_html = '<img src="'.$logotipo['url'].'" alt="Logotipo de la empresa de semillas `'.$nombre.'`" /><br/>';
					}
					$cadena .= "<a class = 'variedad-enlace-empresa intangible emp-$slug' onclick='dameDatosEmpresa($empresa_id)'>";
						$cadena .= $logotipo_html;
						// $cadena .= $nombre;
					$cadena .= "</a>&nbsp;";
				}
				echo "<span class = 'venta-etiqueta cliente empresa'>";
					echo "<br/>";
					// echo "<span>Empresa</span>: ";
					echo $cadena;
				echo "</span>";
			}
			?>
			</div>
						
		</div>		
	</div>	
	<footer class="entry-footer">
		<?php portagrano2023_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
