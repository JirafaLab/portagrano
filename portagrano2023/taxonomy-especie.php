<?php
/**
 * The template for displaying archive Especie
 *
 */

get_header();
	// Banners Rotatorios
	$banners = dameArrayBanners('rotatorios',-1);
	$indicebanners = 0;

	$taxonomia = 'especie';
	$objeto 	= get_queried_object();
	if ( $objeto && ! is_wp_error( $objeto ) )
	{
	    // Padre
		$padre 		= get_term_by('id', $objeto->parent, $taxonomia);
		// Abuelo
		if(!empty($padre))
		{
			$abuelo = get_term_by('id', $padre->parent, $taxonomia);
		}
		// Bisabuelo
		if(!empty($abuelo))
		{
			$bisabuelo = get_term_by('id', $abuelo->parent, $taxonomia);
		}
		$idespecie	= $objeto->term_id;
		$nombre 	= $objeto->name;
		$img		= get_field('imagen_especie', 'especie_' . $idespecie);
		$img_alt 	= $img['alt'];
		$img 		= $img['url'];
		// Enlace
		$enlace_especie = get_term_link($objeto);
	}
	// Banners Rotatorios
	// $banners = dameArrayBanners('rotatorios',-1);
	// $indicebanners = 0;	
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
					if(!empty($padre))
					{
						$termino_enlace = get_term_link( $padre->term_id, $taxonomia);
						$adicion = "<a class ='intangible' href='$termino_enlace'>".$padre->name."</a> / ";
						$nombre = $adicion.$nombre;
					}
					if(!empty($abuelo))
					{
						$termino_enlace = get_term_link( $abuelo->term_id, $taxonomia);
						$adicion = "<a class ='intangible' href='$termino_enlace'>".$abuelo->name."</a> / ";
						$nombre = $adicion.$nombre;
					}
					if(!empty($bisabuelo))
					{
						$termino_enlace = get_term_link( $bisabuelo->term_id, $taxonomia);
						$adicion = "<a class ='intangible' href='$termino_enlace'>".$bisabuelo->name."</a> / ";
						$nombre = $adicion.$nombre;
					}
					echo $nombre;
				?>
				</h2>
			</div>
			<div class="jky-display-flex seccion noticias-destacadas archive-noticias contenido">
				<div class="columna col-3-4">
					<div class="cuerpo contenido-especie">
<?php
/*
						<div class="variedad-otros-nombres">
							<?php
							if (!empty($idespecie)) 
							{
							    $dato = get_term_meta($idespecie, 'otros_nombres', true);
							    if (empty($dato)) {
								    $dato = get_term_meta($padre->term_id, 'otros_nombres', true);
							        if (empty($dato)) {
							            $dato = get_term_meta($abuelo->term_id, 'otros_nombres', true);
							            if (empty($dato)) {
							                $dato = get_term_meta($bisabuelo->term_id, 'otros_nombres', true);
							            }
							        }
							    }
							    echo $dato;
							}
							?>
						</div>
<?php
*/
?>
						
						<div class="variedad-especie">
							<?php
							if (!empty($idespecie)) 
							{
							    $dato = get_term_meta($idespecie, 'nombre_botanico', true);
							    if (!empty($dato)) 
							    {
								    // echo '<h2 class="titulo-tipo-2 principal">Nombre botánico</h2>';
								    echo '<br/>';
								    echo '<span>'.$dato.'</span>';
								    
								    /*
									$dato = get_term_meta($padre->term_id, 'nombre_botanico', true);
							        if (empty($dato)) {
							            $dato = get_term_meta($abuelo->term_id, 'nombre_botanico', true);
							            if (empty($dato)) {
							                $dato = get_term_meta($bisabuelo->term_id, 'nombre_botanico', true);
							            }
							        }
							        */
							    }
							    
							}
							?>
						</div>
						
						<?php
						if(!empty($idespecie))
						{
							$dato = term_description($idespecie);
							if(!empty($dato))
							{
							?>
						<div class="variedad-descripcion">
							<h2 class='titulo-tipo-2'>Características generales</h2>
							<div>
								<?php echo $dato; ?>
							</div>
						</div>
						<?php
							}
						}
						?>
						
						<?php
							// Dats orientativos
						if(!empty($idespecie))
						{
							$dato = get_term_meta($idespecie, 'datos_orientativos', true);
							if(!empty($dato))
							{
							?>
						<div class="variedad-otros-datos">
							<h2 class='titulo-tipo-2'>Datos orientativos</h2>
							<div class="lista-datos-orientativos">
								<div>
									<?php echo $dato; ?>
								</div>
							</div>
						</div>
						<?php
							}
						}
						?>

						<div class="variedad-final jky-display-flex">
							<div class="columna variedad-clasificacion">
								<div>
								<?php
									if(!empty($idespecie))
									{
										$terms = get_terms( array(
											'taxonomy' => $taxonomia,
											'hide_empty' => false,
											'parent' => $idespecie,
											'orderby' => 'term_order'
										));
										$cuantas_clasificaciones = count($terms);
										if(!empty($terms))
										{
											echo "<h2 class='titulo-tipo-2'>Clasificación</h2>";
											if($cuantas_clasificaciones > 6)
											{
												echo "<select onchange='navegarEntreClasiicaciones(this)'>";
													echo "<option value='#'>Elige un tipo</option>";
												foreach ( $terms as $term )
												{
													$idsub		= $term->term_id;
													$nombresub	= $term->name;
													$termino_enlace = get_term_link( $idsub, $taxonomia);
													echo "<option value='$termino_enlace'>$nombresub</option>";
												}
												echo "</select>";
											}
											else
											{
												foreach ( $terms as $term )
												{
													$idsub		= $term->term_id;
													$nombresub	= $term->name;
													$termino_enlace = get_term_link( $idsub, $taxonomia);
													echo "<a class ='enlace-clasificacion termino-1' href='$termino_enlace'>$nombresub</a>";
												}
											}
											
										}										
									}
								?>
								</div>
							</div>
							<div class="columna variedad-fotografía">
								<!-- <h2 class='titulo-tipo-2'>Fotografía</h2> -->
								<div>
									<?php
										if(empty($img)) // Imagen del objeto
										{
											if(!empty($padre)) // Imagen del padre 
											{
												$img		= get_field('imagen_especie', 'especie_' . $padre->term_id);
												$img_alt 	= $img['alt'];
												$img 		= $img['url'];	
											}
											if(empty($img)) // Imagen del abuelo
											{
												$img		= get_field('imagen_especie', 'especie_' . $abuelo->term_id);
												$img_alt 	= $img['alt'];
												$img 		= $img['url'];	
											}
											if(empty($img)) // Imagen del bisabuelo
											{
												$img		= get_field('imagen_especie', 'especie_' . $bisabuelo->term_id);
												$img_alt 	= $img['alt'];
												$img 		= $img['url'];	
											}
										}
										if(empty($imgalt))
											$imgalt = "Portagrano - " . $objeto->name;
										//if(!empty($img))
										echo "<img src='$img' alt='$imgalt'/>";
									?>
								</div>
							</div>
							<?php
							$banner_cadena = '';
							$banner_link = get_field('banner_enlace', 'term_' . $idespecie);
							if ($banner_link) {
								$banner_cadena .= '<a href="'.$banner_link.'" ';
								$banner_pestana_nueva = get_field('banner_pestana_nueva', 'term_' . $idespecie);
								if ($banner_pestana_nueva) {
									$banner_cadena .= 'target="_BLANK"';
								}
								$banner_cadena .= '>';
								$banner_imagen = get_field('banner_imagen', 'term_' . $idespecie);
								if ($banner_imagen) {
									$banner_cadena .= '<img src="'.$banner_imagen['url'].'"/>';
								}
								$banner_cadena .= '</a>';
							}
							if($banner_cadena != '') // Hay banner
							{
								echo '<div class="columna variedad-banner">'.$banner_cadena.'</div>';
							}
							?>
						</div>		
					</div> <!-- Datos de especie -->
					<!-- Variedades de esta especie -->
					<div class="filtros-variedades">
						<form action='' method='GET' id='form-filtros-variedades'>
						<?php
							$caracteristicas_para_filtrado = get_field('caracteristicas_para_filtrado', $objeto);
							if ($caracteristicas_para_filtrado) // Si hay caracterísitcas filtrables en esta taxonomía....
							{
								$opciones_args = array(
							    	'hide_empty' 	=> false,
									'orderby' 		=> 'meta_value',
									'include' 		=> $caracteristicas_para_filtrado,
								);
							
								// $campo = get_terms('caracteristica',array('hide_empty' => false,'orderby'=>'meta_value'));
								$campo = get_terms('caracteristica', $opciones_args);
		
								$seleccionados = isset($_GET['caracteristicas'])? $_GET['caracteristicas'] : [];
								echo helperNiceCheckBoxTax($campo,$seleccionados,'caracteristicas','Filtrar por Características');
								
								echo "<div class = 'caja-filtro botones'>";
									echo "<input type = 'submit' value = 'Filtrar' class = 'btn btn-sumbit'/>";
									echo "<input type = 'reset' value = 'Reiniciar' class = 'btn btn-reset' onclick = 'reseteaBusqueda()'/>";
								echo "</div>";
							}
						?>
						</form>
					</div>
					<?php 
						// Inicialización
						$tax_query = array();
						$caracteristicas= empty($_GET['caracteristicas']) ? 0 : $_GET['caracteristicas'];
						
						// Paginacion
						$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
						// Especie
						if(!empty($idespecie))
						{
							$tax_query[] = array(
							'relation' => 'AND',array(
								'taxonomy' 	=> 'especie',
								'field'		=> 'id',
								'terms'		=> $idespecie,
								'operator'	=> "IN"));
						}
						// Características
						if(!empty($caracteristicas))
						{
							$carac_query = array(
						        'taxonomy'  => 'caracteristica',
								'field'     => 'id',
								'terms'     => $caracteristicas,
								'operator'  => 'AND',
							);
							$tax_query[] = $carac_query;		
						}
						$query = new WP_Query(array(
							'post_type'			=> 'variedad',
							'post_status'		=> 'publish',
							'posts_per_page'	=> 12, // muestra 20 publicaciones por página
							'tax_query' 		=> $tax_query,
							//'meta_query' 		=> $arg_acf,
							'orderby' 			=> 'title',
							'order' 			=> 'ASC',
							'paged' 			=> $paged // establece la página de resultados
						));
/*
						echo "<pre>";
							var_dump($query);
						echo "</pre>";	
*/
						$contador_resultados = $query->found_posts;
						echo capaModoVista($contador_resultados);
						echo '<div class = "contenedor-ventas">';
							echo '<a name="ancla"></a>'; // Ancla para que al paginar baje aquí
						if($query->have_posts())
						{
							// Muestra la paginación
							echo '<div class="paginacion">';
								echo paginate_links(array(
									'total' 		=> $query->max_num_pages,
									'current' 		=> $paged,
									'prev_text' 	=> __('&laquo; Anterior'),
									'next_text' 	=> __('Siguiente &raquo;'),
									'add_fragment'	=> '#ancla', // Agregar el ancla a los enlaces
									));
							echo '</div>';
							while($query->have_posts())
							{
								$query->the_post();
								$id 	= get_the_ID();
								echo dameDatosVentaPHPvistaCard($id, $enlace_especie);
							}
							// Muestra la paginación
							echo '<div class="paginacion">';
								echo paginate_links(array(
									'total' 		=> $query->max_num_pages,
									'current' 		=> $paged,
									'prev_text' 	=> __('&laquo; Anterior'),
									'next_text' 	=> __('Siguiente &raquo;'),
									'add_fragment'	=> '#ancla', // Agregar el ancla a los enlaces
									));
							echo '</div>';
						}
						else
						{
							echo "<span class = 'resultados-encontrados ninguno'>Ninguna variedad encontrada con estos parámetros</span>";
						}
						echo '</div>';
					?>
				</div> <!-- .columna.col-3-4 -->
				<div class="columna col-1-4 jky-display-flex banners">
					<?php 
						$bannerfijo = dameArrayBanners('fijo-1',1);
						pintaAnuncio($bannerfijo, 0);
						$bannerfijo = dameArrayBanners('fijo-2',1);
						pintaAnuncio($bannerfijo, 0);
						$bannerfijo = dameArrayBanners('fijo-3',1);
						pintaAnuncio($bannerfijo, 0);
						$bannerfijo = dameArrayBanners('fijo-4',1);
						pintaAnuncio($bannerfijo, 0);
						
						while($indicebanners < count($banners))
						{
							$indicebanners = pintaAnuncio($banners, $indicebanners);
						}						
					?>
				</div>
			</div><!-- .jky-display-flex.seccion-ultimas-noticias.contenido -->
		</div>
	</main><!-- #main -->
<?php
get_footer();