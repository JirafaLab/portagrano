<?php
/**
 * Plugin Name: JKY: Grabar Semillas Frontend
 * Description: Plugin para crear semillas desde FrontEnd. Contiene el CPT "semillas" y sus datos asociados<br/> <strong>NO BORRAR NI DESACTIVAR</strong>
 * Author: Juanky Castillo
 * Author URI: https://jirafastudio.com/
 * Version: 0.1
 *
 * @package jky_semillas_frontend
 */

// Evita que se llame directamente a este fichero sin pasar por WordPress.
defined( 'ABSPATH' ) || die();

/*
Añadir llamadas a funcion y Ajax
*/
define('JKY_SF_URL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );

function jky_sf_enqueuescripts()
{
    wp_enqueue_script('JKY_sf', JKY_SF_URL.'/js/JKY_sf.js', array('jquery'));
    wp_localize_script('JKY_sf', 'JKY_sf', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'jky_sf_enqueuescripts');

// Crea el CPT al activar el plugin.
/* CPTs y TAXonomias */
function jky_sf_custom_cpt()
{
//	add_theme_support( 'post-thumbnails' );
	/*
	* Post Type: Ventas
	*/
	$labels = array(
		"name" => __( "Variedades", "" ),
		"singular_name" => __( "Variedad", "" ),
		'search_items'          => __( 'Buscar variedad', '' ),
		'edit_item'             => __( 'Editar variedad', '' ),
		'add_new_item'          => __( 'Añadir nueva variedad', '' )
	);
	$args = array(
		"label" => __( "variedades", "" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		'show_in_rest' => true, // Needed for tax to appear in Gutenberg editor
		"exclude_from_search" => false,
		"capability_type" => "semilla",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "variedad", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 4,
		"menu_icon" => "dashicons-palmtree",
		'supports' => array( 'title', 'editor', 'thumbnail')
	);
	register_post_type( "variedad", $args );
		/*
	* Post Type: Enfermedades
	*/
	$labels = array(
		"name" => __( "Enfermedades", "" ),
		"singular_name" => __( "Enfermedad", "" ),
		'search_items'          => __( 'Buscar enfermedad', '' ),
		'edit_item'             => __( 'Editar enfermedad', '' ),
		'add_new_item'          => __( 'Añadir nueva enfermedad', '' )
	);
	$args = array(
		"label" => __( "Enfermedades", "" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		'show_in_rest' => true, // Needed for tax to appear in Gutenberg editor
		"exclude_from_search" => false,
		"capability_type" => "enfermedad",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "enfermedad", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 4,
		"menu_icon" => "dashicons-warning",
		"supports" => array("title","editor", "slug"),
	);
	register_post_type( "enfermedad", $args );
}
add_action('init','jky_sf_custom_cpt');
/*
Creación de Taxonomias
*/
function jky_vf_custom_tax() 
{
	/**
	* Taxonomy: Especie
	*/
	$labels = array(
		"name" => __( "Especies", "" ),
		"singular_name" => __( "Especie", "" ),
	);
	$args = array(
		"label" => __( "Especie", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Especie",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'especie', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "especie", array("variedad","enfermedad"), $args );	
	/**
	* Taxonomy: Características de semilla
	*/
	$labels = array(
		"name" => __( "Características", "" ),
		"singular_name" => __( "Característica", "" ),
	);
	$args = array(
		"label" => __( "Característica", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Característica",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'caracteristica', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "caracteristica", array("variedad"), $args );
	
	$labels = array(
		"name" => __( "Empresas de Semillas", "" ),
		"singular_name" => __( "Empresa", "" ),
	);
	$args = array(
		"label" => __( "Empresa", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Empresas",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'empresa', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "empresa", array("variedad"), $args );
}
add_action('init','jky_vf_custom_tax');


/* reordenar un Array */
function sort_terms_hierarchically( array &$terms, array &$into, $parent_id = 0 )
{
    foreach ( $terms as $i => $term )
    {
        if($term->parent == $parent_id )
        {
            $into[$term->term_id] = $term;
            unset( $terms[ $i ] );
        }
    }
    foreach ( $into as $top_term )
    {
        $top_term->children = array();
        sort_terms_hierarchically( $terms, $top_term->children, $top_term->term_id );
    }
}
function dameTerminosDeVariedad($array,$devolver = array(),$indice = 0)
{
    foreach($array as $linea)
    {
	    $devolver[$indice] = $linea->term_id;
	    if(!empty($linea->children)) // Si tiene hijos
	    {
			$array = $linea->children;
			$indice++;
			$devolver = dameTerminosDeVariedad($array,$devolver,$indice);
	    }
	}
    return $devolver;
}



// Mostrar el formulario
function jky_semilla_frontend_funcion($id = 0)
{
	if(isset($_GET['jky_semillas_frontend_texto_aviso'])){echo "<h4>".$_GET['jky_semillas_frontend_texto_aviso']."</h4>";}
	
	$nombre				= "";
	$esnuevo =true;
	if($id != 0)
	{
		$esnuevo = false;
		global $post; 
		$post = get_post($id,OBJECT);
		setup_postdata($post);
		
		$nombre				= get_the_title($id);
	}
	// $codigo_id		= empty(get_post_meta($id,'codigo_id',true))? "" : get_post_meta($id,'codigo_id',true);
	
	$fecha_a					= formateaFechaAAAAMMDDtoHTML(get_post_meta($id,'fecha_alta',true));
	$empresa					= get_the_terms($id,'empresa');
	$especies_desordenadas		= get_the_terms($id,'especie');
	if(empty($especies_desordenadas))
		$especies_desordenadas = array();
	$especies = array();
	sort_terms_hierarchically($especies_desordenadas, $especies );
	$terminos = dameTerminosDeVariedad($especies);
	
	

	
	$caracteristicas			= get_the_terms($id,'caracteristica');
	$informacion_extra			= get_post_meta($id,'informacion_extra',true);
	$enf_resistencia_alta		= empty(get_post_meta($id,'enf_resistencia_alta',true))? "" : get_post_meta($id,'enf_resistencia_alta',true);
	$enf_resistencia_intermedia	= empty(get_post_meta($id,'enf_resistencia_intermedia',true))? "" : get_post_meta($id,'enf_resistencia_intermedia',true);
	$enf_tolerancia				= empty(get_post_meta($id,'enf_tolerancia',true))? "" : get_post_meta($id,'enf_tolerancia',true);
	
	$user_is_admin = userEsAdmin();
	?>
	<form name="nueva" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data" id="jky-semillas-frontend-form">
		<?php wp_nonce_field('jky-semilla-frontend-form', 'jky-semilla-frontend-form-nonce'); ?>
		<input type="hidden" name="action" value="jky-grabar-semilla-frontend">
		<input type="hidden" name="jky-semilla-frontend-url-origen" value="<?php echo home_url('/crear-editar-variedad/'); ?>">
		<?php
			if($_GET['id_variedad'] != 0)
			{
				echo '<input type="hidden" name="id_variedad" value="'.$id.'">';
			}
		?>
		<div class = 'caja-semilla crear-editar-semilla'>
			<div class = 'semilla-cabecera'>
				<div class = 'semilla-id'>
					<span class = 'semilla-icono id-semilla'># <span> <?php echo $id; ?></span>
				</div>
				<div class = 'semilla-estado'>
					<?php
						echo '<div class = "caja-fecha">';
							echo '<div class = "caja-fecha-paquete">';
								echo '<span class = "filtro-mensaje neutro"><strong>Fecha Alta</strong></span>';
								echo pintaInputVentaFECHA('fecha_alta',$fecha_a);
							echo '</div>';
						echo '</div>';
					?>
				</div>
			</div> <!-- semilla-cabecera -->
			<div class = 'semilla-datos-basicos'>
				<div class = 'caja-contenedora-inputs'>
					<h5>Datos básicos:</h5>
					<label class="jky-display-flex">
						<span>Nombre:</span>
						<?php
							echo pintaInputVentaTXT('nombre',$nombre,'Nombre de la variedad');
						?>
					</label>
					<label class="jky-display-flex">
						<span>Empresa:</span>
						<?php
							echo pintaInputVentaTaxonomiaEmpresa('empresa',$empresa,'empresa[]');
						?>
					</label>
					
					<span class = 'semilla-etiqueta especies'>
						<label class="especies-selectables jky-display-flex">
							<span id="etiqueta-especie">Especie:</span>
							<?php
								$terminos = empty($terminos)? 0 : $terminos;
								$valorp = $valorh = $valorn = $valornn = 0;
								$padrep = $padreh = $padren = $padrenn = 0;
								if(!empty($terminos))
								{
									if($terminos[0] != null)
									{
										$valorp = $terminos[0];
										$padreh = $terminos[0];
										if($terminos[1] != null)
										{
											$valorh = $terminos[1];
											$padren = $terminos[1];
											if($terminos[2] != null)
											{
												$valorn = $terminos[2];
												$padrenn = $terminos[2];
												if($terminos[3] != null)
												{
													$valornn = $terminos[3];
												}
											}
										}
									}
								}
							echo '<div id="caja-selects-especies">';
								echo pintaSemillaSelectEspecie('especie', $padrep, $valorp,'especie[]', 'clasificacion1');
								echo pintaSemillaSelectEspecie('especie', $padreh, $valorh,'especie[]', 'clasificacion2');
								echo pintaSemillaSelectEspecie('especie', $padren, $valorn,'especie[]', 'clasificacion3');
								echo pintaSemillaSelectEspecie('especie', $padrenn, $valornn,'especie[]', 'clasificacion4');
							echo '</div>';
							?>
						</label>
					</span>
				</div>
				<div class = 'caja-contenedora-inputs'>
					<h5>Características:</h5>
					<?php
						$caracteristicas = wp_list_pluck($caracteristicas, 'term_id');
						echo pintaInputNiceCheckBoxTaxonomia('caracteristica',$caracteristicas);
					?>
				</div>
				<div class = 'caja-contenedora-datos'>
					<h5>Descripción:</h5>
					<?php
$args = array(
	'textarea_name'	=>'informacion_extra',
	'quicktags' 	=> false,
	'textarea_rows' => 5,
	'media_buttons' => false,
	'tinymce'       => array(
		'toolbar1'    => 'bold,italic,bullist,strikethrough,underline,forecolor,charmap,outdent,indent,removeformat',
		'toolbar2'    => '',)
	); 
$editor_id = 'informacion_extra';
wp_editor($informacion_extra,$editor_id,$args);
					?>
				</div>
<?php
/*
				<div class = 'caja-contenedora-datos variedad-otros-datos'>
					<h5>Datos Orientativos:</h5>
					<?php
					if(!empty($termino))
					{
						$dato = get_term_meta($termino, 'datos_orientativos',true);
						echo $dato;
					}
					?>
				</div>
*/
?>
				<div class = 'caja-contenedora-inputs enfermedades'>
					<h5>Enfermedades:</h5>
					<label>
						<span>Resistencia ALTA:</span>
						<?php echo pintaInputSemillaEnfermedades($id,'enf_resistencia_alta', $valorp); ?>
					</label>
					<label>
						<span>Resistencia INTERMEDIA:</span>
						<?php echo pintaInputSemillaEnfermedades($id,'enf_resistencia_intermedia', $valorp); ?>
					</label>					
					<label>
						<span>Tolerancia:</span>
						<?php echo pintaInputSemillaEnfermedades($id,'enf_tolerancia', $valorp); ?>
					</label>
				</div> <!-- semilla-enfermedades -->
				<div class = 'caja-contenedora-inputs imagen'>
					<h5>Imagen:</h5>					
					<label>
						<span>Imagen 1:</span>
						<br/>
						<?php
							$url_foto="";
							if($id != 0)
							{
								if(has_post_thumbnail($id))
								{
									$url_foto=get_the_post_thumbnail_url($id);
									$image_id = get_post_thumbnail_id($id);
								}	
							}
						?>
						<input type="checkbox" name="eliminar_imagen_1" value="<?php echo $image_id ?>"/> Eliminar Imagen
						<div id="preview_1" style="width: 250px; display: block;margin:0 auto">
							<img id="previewimg_1" src="<?php echo $url_foto ?>" style="max-width:100%;height:auto">
						</div>
						<input class="imagen-semilla" id="imagen1" name="imagen1" type="file">
						<div id="detail">	
							<div id="message_1"></div>
						</div>
					</label>
					<hr/>
					<label>
						<span>Imagen 2:</span>
						<br/>
						<?php
							$url_foto="";
							if($id != 0)
							{
								$image = get_field('imagen_2');
								if( $image )
								{
									$url_foto = $image['url'];
									$image_id = $image['ID'];
								}
							}
						?>
						<input type="checkbox" name="eliminar_imagen_2" value="<?php echo $image_id ?>"/> Eliminar Imagen
						<div id="preview_2" style="width: 250px; display: block;margin:0 auto">
							<img id="previewimg_2" src="<?php echo $url_foto ?>" style="max-width:100%;height:auto">
						</div>
						<input class="imagen-semilla" id="imagen2" name="imagen_2" type="file">
						<div id="detail">	
							<div id="message_2"></div>
						</div>
					</label>
					<hr/>
					<label>
						<span>Imagen 3:</span>
						<br/>
						<?php
							$url_foto="";
							if($id != 0)
							{
								$image = get_field('imagen_3');
								if( $image )
								{
									$url_foto = $image['url'];
									$image_id = $image['ID'];
								}
							}
						?>
						<input type="checkbox" name="eliminar_imagen_3" value="<?php echo $image_id ?>"/> Eliminar Imagen
						<div id="preview_3" style="width: 250px; display: block;margin:0 auto">
							<img id="previewimg_3" src="<?php echo $url_foto ?>" style="max-width:100%;height:auto">
						</div>
						<input class="imagen-semilla" id="imagen3" name="imagen_3" type="file">
						<div id="detail">	
							<div id="message_3"></div>
						</div>
					</label>
					<hr/>
					<label>
						<span>Imagen 4:</span>
						<br/>
						<?php
							$url_foto="";
							if($id != 0)
							{
								$image = get_field('imagen_4');
								if( $image )
								{
									$url_foto = $image['url'];
									$image_id = $image['ID'];
								}
							}
						?>
						<input type="checkbox" name="eliminar_imagen_4" value="<?php echo $image_id ?>"/> Eliminar Imagen
						<div id="preview_4" style="width: 250px; display: block;margin:0 auto">
							<img id="previewimg_4" src="<?php echo $url_foto ?>" style="max-width:100%;height:auto">
						</div>
						<input class="imagen-semilla" id="imagen4" name="imagen_4" type="file">
						<div id="detail">	
							<div id="message_4"></div>
						</div>
					</label>
					<hr/>
				</div> <!-- semilla-imagen -->
			</div>
		</div> <!-- caja-semilla -->
		<input class="btn btn-sumbit" type="submit" name="jky-semillas-frontend-submit" value="Guardar Variedad">
	</form>
	<?php
}


// Agrega los action hooks para grabar el formulario:
// El primero para usuarios logeados y el otro para el resto.
// Lo que viene tras admin_post_ y admin_post_nopriv_ tiene que coincidir con el value del campo input con name "action" del formulario.
add_action( 'admin_post_jky-grabar-semilla-frontend', 'jky_grabar_semilla_frontend' );
//add_action( 'admin_post_nopriv_jky-grabar-semilla-frontend', 'jky_grabar_semilla_frontend' );
function jky_grabar_semilla_frontend()
{
	if(filter_has_var(INPUT_POST, 'jky-semilla-frontend-url-origen'))
	{
		$url_origen = filter_input(INPUT_POST, 'jky-semilla-frontend-url-origen', FILTER_SANITIZE_URL);
	}
	$post_id = 0;
	if(isset($_POST['id_variedad']))
	{
		// Ya existe la semilla
		$post_id = $_POST['id_variedad'];
		include JKY_SF_URL."/jky_sf_subida.php";
		actualizaMetaDatos($post_id,$_POST);
	}
	else
	{
		$titulo = $_POST['nombre'];
		$args = array(
			'post_title'     => $titulo,
			'post_content'   => '',
			'post_type'      => 'variedad',
			'post_status'    => 'draft',
			'comment_status' => 'closed',
			'ping_status'    => 'closed'
		);
		// Esta variable $post_id contiene el ID del nuevo registro 
		// Nos vendría de perlas para grabar los metadatos
		$post_id = wp_insert_post($args);
		$post_update = array('ID'=>$post_id,'post_title'=>$titulo);
		
		include JKY_SF_URL."/jky_sf_subida.php";
		
		wp_update_post($post_update);
		actualizaMetaDatos($post_id,$_POST);
	}	
	/*
	echo "<pre>";
		var_dump($_FILES);
	echo "</pre>";
	*/
	// Imagen Destacada
	$thumbnail_field = 'imagen1';
	if(!empty($_FILES[$thumbnail_field])) {
		foreach ($_FILES as $file => $array) {
			if($file === $thumbnail_field) {
				// La clave es "imagen1
				$newupload = insert_attachment($file, $post_id, $thumbnail_field);
				echo "<h3>Destacada: $newupload</h3>";
			}
			
		}
	}
	// Imagenes adicionales de ACF (imagen2, imagen3, imagen4)
	$image_fields = array('imagen_2', 'imagen_3', 'imagen_4');
	foreach ($image_fields as $image_field) {
		if (!empty($_FILES[$image_field]['tmp_name'])) {
			$file = $_FILES[$image_field];
			$upload_overrides = array('test_form' => false);
			$movefile = wp_handle_upload($file, $upload_overrides);
			
			if ($movefile && !isset($movefile['error'])) {
				$attachment_args = array(
					'post_mime_type' => $file['type'],
					'post_title' => $file['name'],
					'post_content' => '',
					'post_status' => 'inherit'
				);

				$attachment_id = wp_insert_attachment($attachment_args, $movefile['file'], $post_id);

				if (!is_wp_error($attachment_id)) {
					update_field($image_field, $attachment_id, $post_id);
					echo "<h3>Archivo subido y asignado a $image_field correctamente</h3>";
				} else {
					echo "<h3>Error al subir el archivo y asignarlo a $image_field</h3>";
				}
			} else {
				echo "<h3>Error al subir el archivo y asignarlo a $image_field</h3>";
			}
		}
	}

	wp_publish_post($post_id);
	wp_redirect(esc_url_raw($url_origen.'?id_variedad='.$post_id));
	exit();
}
function actualizaMetaDatos($idsemilla,$datos)
{
	
	/*
	echo "<pre>";
		var_dump($datos);
	echo "</pre>";
	*/
	$clasificacion = $caracteristicas = $otros_nombres = $empresas = $enf_res_alta = $enf_res_intermedia = $enf_res_tolerancia = array();
	
	// Asigna el slug
	$slug_personalizado = sanitize_title($datos['nombre']) . '-' . $idsemilla;
	wp_update_post(array(
		'ID' => $idsemilla,
		'post_title'=>$datos['nombre'],
		'post_name' => $slug_personalizado, // Actualizar el slug
		));
	// Vaciar caracteristicas para rellenarlos si no está vacio
	wp_set_post_terms($idsemilla, [],'caracteristica');
	// Vaciar enfermedadesd para rellenarlos si no está vacio
	update_post_meta($idsemilla,'enf_resistencia_alta',[]);
	update_post_meta($idsemilla,'enf_resistencia_intermedia',[]);
	update_post_meta($idsemilla,'enf_tolerancia',[]);
	
	foreach($datos as $clave=>$dato)
	{
		switch($clave)
		{
			case '_wp_http_referer':
			case 'action':
			case 'jky-venta-frontend-url-origen':
			case 'jky-ventas-frontend-submit':
			case 'jky-venta-frontend-form-nonce':
			case 'empresa':
				foreach($dato as $empre)
				{
					$empresas[] = intval($empre);
				}
				wp_set_post_terms($idsemilla, $empresas,'empresa');
				break;
			case 'especie':
				wp_set_post_terms($idsemilla, $dato,'especie');
				break;
			case 'caracteristicas':
				foreach($dato as $carac)
				{
					$caracteristicas[] = intval($carac);
				}
				wp_set_post_terms($idsemilla, $caracteristicas,'caracteristica');
				break;
			case 'informacion_extra':
				update_post_meta($idsemilla,'informacion_extra',$dato);
				break;
			case 'enf_resistencia_alta':
				update_post_meta($idsemilla,'enf_resistencia_alta',$dato);
				break;
			case 'enf_resistencia_intermedia':
				update_post_meta($idsemilla,'enf_resistencia_intermedia',$dato);
				break;
			case 'enf_tolerancia':
				update_post_meta($idsemilla,'enf_tolerancia',$dato);
				break;
			case 'fecha_alta':
				update_post_meta($idsemilla,'fecha_alta',$dato);
				break;
			case 'eliminar_imagen_1':
				$image_id = $dato;
				wp_delete_attachment( $image_id, true );
				delete_post_thumbnail( $idsemilla );
				break;
			case 'eliminar_imagen_2':
				$image_id = $dato;
				wp_delete_attachment($image_id, true);
				break;
			case 'eliminar_imagen_3':
				$image_id = $dato;
				wp_delete_attachment($image_id, true);
				break;
			case 'eliminar_imagen_4':
				$image_id = $dato;
				wp_delete_attachment($image_id, true);
				break;
		}
	}
}
/* Ajax */

add_action('wp_ajax_jky_dame_opciones_select', 'jky_dame_opciones_select');
add_action('wp_ajax_nopriv_jky_dame_opciones_select', 'jky_dame_opciones_select');
function jky_dame_opciones_select()
{
	$cat_padre	= $_GET['cat_padre'];
	$categorias = get_terms('especie',array('parent' => $cat_padre,'hide_empty' => false,'orderby'=>'meta_value'));
	$devolver 	= '<option value=""></option>';
	foreach($categorias as $cat)
	{
		$devolver .= '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
	}
	wp_send_json($devolver);
	wp_die();
}


add_action('wp_ajax_jky_dame_opciones_select_enfermedades', 'jky_dame_opciones_select_enfermedades');
add_action('wp_ajax_nopriv_jky_dame_opciones_select_enfermedades', 'jky_dame_opciones_select_enfermedades');
function jky_dame_opciones_select_enfermedades()
{
	$especie	= $_GET['tipo'];
	$tarea		= $_GET['tarea'];
	
	$query = new WP_Query(array(
	    'post_type' => 'enfermedad',
	    'post_status' => 'publish',
	    'posts_per_page' => -1,
	    'tax_query' => array(
	        array(
	            'taxonomy' => 'especie',
	            'field' => 'id',
	            'terms' => $especie,
	        ),
	    ),
		'orderby'        => 'title',
		'order'          => 'ASC'
	));
	
	$devolver=array();
	if ($query->have_posts())
	{	
		if($tarea == 'busqueda') {
		$devolver[0] = '<div class="opciones-enfermededades">';
			$devolver[0] .= '<input type="radio" id="opcion-una" name="enfermedades-opciones" value="una" checked="checked">';
			$devolver[0] .= '&nbsp;';
			$devolver[0] .= '<label for="opcion-una"> Cumplir al menos una de las opciones</label>';
			$devolver[0] .= '&nbsp;&nbsp;&nbsp;';
			$devolver[0] .= '<input type="radio" id="opcion-todas" name="enfermedades-opciones" value="todas">';
			$devolver[0] .= '&nbsp;';
			$devolver[0] .= '<label for="opcion-todas"> Cumplir todas a la vez</label>';
		$devolver[0] .= '</div>';
		}
		
		$devolver[0] .= '<select class = "input-select posible-select2 input-select-multiple select-enfermedades" name="enf_resistencia_alta[]" id="select_enf_resistencia_alta[]"  multiple="multiple">';
		$devolver[1] = '<select class = "input-select posible-select2 input-select-multiple select-enfermedades" name="enf_resistencia_intermedia[]" id="select_enf_resistencia_intermedia[]"  multiple="multiple">';
		$devolver[2] = '<select class = "input-select posible-select2 input-select-multiple select-enfermedades" name="enf_tolerancia[]" id="select_enf_tolerancia[]"  multiple="multiple">';
	    while ($query->have_posts())
	    {
	        $query->the_post();
	        $select_id 		= get_the_ID();
	        // $select_label 	= get_the_title();
	        $select_label 	= get_post_meta($select_id, 'enfermedad_codigo', true);
	        
	    	$devolver[0] .= '<option value="'.$select_id.'">'.$select_label.'</option>';
			$devolver[1] .= '<option value="'.$select_id.'">'.$select_label.'</option>';
			$devolver[2] .= '<option value="'.$select_id.'">'.$select_label.'</option>';
	    }
	    $devolver[0] .= '</select>';
		$devolver[1] .= '</select>';
		$devolver[2] .= '</select>';
	    wp_reset_postdata();
	}
	wp_send_json($devolver);
	wp_die();
}

add_action('wp_ajax_jky_dame_opciones_caracteristicas', 'jky_dame_opciones_caracteristicas');
add_action('wp_ajax_nopriv_jky_dame_opciones_caracteristicas', 'jky_dame_opciones_caracteristicas');
function jky_dame_opciones_caracteristicas()
{
	$especie	= $_GET['especie']; // ID del término en la taxonomía 'especie'
	
	$devolver = '';
	$devolver .= filtrosDinamicosCaracteristicas($especie);
	
	wp_send_json($devolver);
	wp_die();
}



/* Helpers */
function filtrosDinamicosCaracteristicas($especie, $seleccionados = [])
{
	$devolver = '';
	$especie_term = get_term($especie, 'especie'); // Obtén el objeto del término usando su ID y el nombre de la taxonomía
	$caracteristicas_para_filtrado = get_field('caracteristicas_para_filtrado', $especie_term);
	if(!$caracteristicas_para_filtrado)
		return '<div id="buscador-seccion-caracteristicas">Elige primero una especie para poder filtrar por sus características</div>';
	
	$opciones_args = array(
		'hide_empty' 	=> false,
		'orderby' 		=> 'meta_value',
		'include' 		=> $caracteristicas_para_filtrado,
	);
	$campo = get_terms('caracteristica', $opciones_args);
	$seleccionados = isset($_GET['caracteristicas'])? $_GET['caracteristicas'] : [];
	$devolver = helperNiceCheckBoxTax($campo,$seleccionados,'caracteristicas','');
	
	return $devolver;
}
function pintaInputVentaTXT($name,$value,$placeholder)
{
	return '<input type = "text" class = "input-semilla input-txt disablecopypaste" name = "'.$name.'" value ="'.$value.'" placeholder = "'.$placeholder.'" id = "'.$name.'"/>';
}
function pintaInputVentaHIDDEN($name,$value)
{
	return '<input type = "hidden" class = "input-semilla input-hidden" name = "'.$name.'" value ="'.$value.'" id = "'.$name.'"/>';
}
function pintaInputVentaFECHA($name,$value)
{
	$devolver = "";
	if(empty($value))
	{
		$value = date("Y-m-d");
	}
	$devolver = '<input type = "date" class = "input-semilla input-fecha disablecopypaste" name = "'.$name.'" value ="'.$value.'"/>';
	return $devolver;
}
function pintaInputVentaTaxonomia($taxonomia,$valor,$name)
{
	$campo = get_terms($taxonomia,array('hide_empty' => false,'orderby'=>'meta_value'));
	if($name=="empresa")
	{
		// Permitimos multiple
		$devolver = '<select class = "input-semilla input-select input-select-multiple select-tax-'.$taxonomia.' posible-select2" name="'.$name.'" multiple="multiple">';
	}
	else
	{
	$devolver = '<select class = "input-semilla input-select select-tax-'.$taxonomia.' posible-select2" name="'.$name.'">';
	}
		$devolver .= '<option></option>';
	foreach ($campo as $seleccion)
	{
		$select_id		= $seleccion->term_id;
		$select_label	= $seleccion->name;
		$seleccionado 	= $select_id==$valor? 'selected="selected"' : '';
		$devolver .= '<option value="'.$select_id.'" '.$seleccionado.'>'.$select_label.'</option>';
	}
	$devolver .= '</select>';
	return $devolver;
}
function pintaInputVentaTaxonomiaEmpresa($taxonomia,$valor,$name)
{
	$campo = get_terms($taxonomia,array('hide_empty' => false,'orderby'=>'meta_value'));
	$devolver = '<select class = "input-semilla input-select input-select-multiple select-tax-'.$taxonomia.' posible-select2" name="'.$name.'" multiple="multiple">';
		$devolver .= '<option></option>';
	foreach ($campo as $seleccion)
	{
		$select_id		= $seleccion->term_id;
		$select_label	= $seleccion->name;
		$seleccionado 	= '';
		if(!empty($valor))
		{
			foreach($valor as $cadavalor)
			{
				if($cadavalor->term_id == $select_id)
					$seleccionado = 'selected="selected"';
			}
		}
		
		$devolver .= '<option value="'.$select_id.'" '.$seleccionado.'>'.$select_label.'</option>';	
	}
	$devolver .= '</select>';
	return $devolver;
}

function pintaSemillaSelectEspecie($taxonomia, $padre, $valor, $name, $id, $buscador=false)
{
	$campo = get_terms($taxonomia,array('parent' => $padre,'hide_empty' => false,'orderby'=>'meta_value'));
	if($id=="clasificacion1")
	{
		if($buscador)
			$devolver = '<select id="'.$id.'" class = "select-buscador input-semilla input-select select-familia select-tax-'.$taxonomia.' posible-select2" name="'.$name.'" data-tarea="busqueda" onchange="inputSelectCambia(this)">';
		else
			$devolver = '<select id="'.$id.'" class = "input-semilla input-select select-familia select-tax-'.$taxonomia.' posible-select2" name="'.$name.'" data-tarea="creacion" onchange="inputSelectCambia(this)">';
	}
	else
		$devolver = '<select id="'.$id.'" class = "input-semilla input-select select-familia select-tax-'.$taxonomia.' posible-select2" name="'.$name.'" onchange="inputSelectCambia(this)">'; 
		
	$devolver .= '<option></option>';
	foreach ($campo as $seleccion)
	{
		$select_id		= $seleccion->term_id;
		$select_label	= $seleccion->name;
		$seleccionado 	= $select_id==$valor? 'selected="selected"' : '';
		$devolver .= '<option value="'.$select_id.'" '.$seleccionado.'>'.$select_label.'</option>';
	}
	$devolver .= '</select>';
	$devolver .= '&nbsp;';
	return $devolver;
}

function pintaInputSemillaEnfermedades($idsemilla, $enf_codigo, $especie='', $seleccionados=false)
{
	$devolver = "";
	$enfermedades = array();
	$enfermedades = get_post_meta($idsemilla,$enf_codigo, true);
	$enfermedades = is_array($enfermedades) ? $enfermedades : array($enfermedades);
	// jky_debug_vardump($especie);
	
	if($especie == 0) {
		$devolver .= '<div id="select-enfermedades-'.$enf_codigo.'" class="select-enfermedades-caja">';
			$devolver .= 'Elige primero una especie para poder asignarle tolerancias a enfermedades';
			$devolver .= '<select class = "input-select posible-select2 input-select-multiple select-enfermedades" name="'.$enf_codigo.'[]" id="select_'.$enf_codigo.'[]"  multiple="multiple">';
			$devolver .= '</select>';
		$devolver .= '</div>';
		return $devolver;
	}
	else {
		$query = new WP_Query(array(
		    'post_type' => 'enfermedad',
		    'orderby' => 'name',
		    'order' => 'ASC',
		    'posts_per_page' => -1,
		    'tax_query' => array(
		        array(
		            'taxonomy' => 'especie',
		            'field' => 'id',
		            'terms' => $especie,
		        ),
		    ),
		));		
	}
	
	foreach($query->posts as $product_id=>$macthed_product)
	{
		// $choices[$macthed_product->ID] = $macthed_product->post_title;
		$choices[$macthed_product->ID] = get_post_meta($macthed_product->ID, 'enfermedad_codigo', true);
	}
	if(is_array($choices))
	{
	
	$devolver .= '<div id="select-enfermedades-'.$enf_codigo.'" class="select-enfermedades-caja">';
		$devolver .= '<select class = "input-select posible-select2 input-select-multiple select-enfermedades" name="'.$enf_codigo.'[]" id="select_'.$enf_codigo.'[]"  multiple="multiple">';
	    foreach($choices as $key=>$choice )
	    {
	        $select_id 		= $key;
	        $select_label	= $choice;
	        $checked = in_array($select_id, $enfermedades)? 'selected="selected"' : '';
	        $devolver .= '<option value="'.$select_id.'" '.$checked.'>'.$select_label.'</option>';
	    }
	    $devolver .= '</select>';
	$devolver .= '</div>';
	}
	return $devolver;
}

function pintaInputSemillaEnfermedadesBusqueda($idsemilla, $enf_codigo, $especie='', $seleccionados=false)
{
	$devolver = "";
	$enfermedades = array();
	if($idsemilla == 0) {
		if(!empty($seleccionados))
			$enfermedades = $seleccionados;
	}
	else {
		$enfermedades = get_post_meta($idsemilla,$enf_codigo, true);
		$enfermedades = is_array($enfermedades) ? $enfermedades : array($enfermedades);
		// jky_debug_vardump($enfermedades);
	}
	
	if($especie == 0) {
		$devolver .= 'Elige primero una especie para poder filtrar por sus enfermedades';
		return $devolver;
	}
	else {
		$query = new WP_Query(array(
		    'post_type' => 'enfermedad',
		    'orderby' => 'name',
		    'order' => 'ASC',
		    'posts_per_page' => -1,
		    'tax_query' => array(
		        array(
		            'taxonomy' => 'especie',
		            'field' => 'id',
		            'terms' => $especie,
		        ),
		    ),
		));		
	}
	
	foreach($query->posts as $product_id=>$macthed_product)
	{
		// $choices[$macthed_product->ID] = $macthed_product->post_title;
		$choices[$macthed_product->ID] = get_post_meta($macthed_product->ID, 'enfermedad_codigo', true);
	}
	if(is_array($choices))
	{
	$devolver .= '<div class="opciones-enfermededades">';
		$seleccionados_opciones = isset($_GET['enfermedades-opciones'])? $_GET['enfermedades-opciones'] : 'una';
		$checked = $seleccionados_opciones=='una' ? 'checked="checked"' : '';
		$devolver .= '<input type="radio" id="opcion-una" name="enfermedades-opciones" value="una" '. $checked . '>';
		$devolver .= '&nbsp;';
		$devolver .= '<label for="opcion-una"> Cumplir al menos una de las opciones</label>';
		$devolver .= '&nbsp;&nbsp;&nbsp;';
		$checked = $seleccionados_opciones=='todas' ? 'checked="checked"' : '';
		$devolver .= '<input type="radio" id="opcion-todas" name="enfermedades-opciones" value="todas" ' . $checked . '>';
		$devolver .= '&nbsp;';
		$devolver .= '<label for="opcion-todas"> Cumplir todas a la vez</label>';
	$devolver .= '</div>';
	
	$devolver .= '<div id="select-enfermedades-'.$enf_codigo.'" class="select-enfermedades-caja">';
		$devolver .= '<select class = "input-select posible-select2 input-select-multiple select-enfermedades clas-'.$especie.'" name="'.$enf_codigo.'[]" id="select_'.$enf_codigo.'[]"  multiple="multiple">';
	    foreach($choices as $key=>$choice )
	    {
	        $select_id 		= $key;
	        $select_label	= $choice;
	        $checked = in_array($select_id, $enfermedades)? 'selected="selected"' : '';
	        $devolver .= '<option value="'.$select_id.'" '.$checked.'>'.$select_label.'</option>';
	    }
	    $devolver .= '</select>';
	$devolver .= '</div>';
	}
	return $devolver;
}


/* Helper para dibujar modo checkbox nice Caracteristicas */
function pintaInputNiceCheckBoxTaxonomia($tax,$caracteristicas)
{
	$devolver = "";
	$campo = get_terms($tax, array('hide_empty' => false, 'orderby'  => 'id', 'order'    => 'DESC'));
	$devolver .= '<div class="caja-contenedora-servicios-contratados">';
	foreach ($campo as $seleccion)
	{
		$select_id		= $seleccion->term_id;
		$select_label	= $seleccion->name;
		$seleccionado 	= "";
		if(in_array($select_id, $caracteristicas))
			$seleccionado 	= 'checked="checked"';		
		$devolver .= '<label class="container-nice-none">';
			$devolver .= '<span class = "semilla-icono estado servicio_contratado sc-'.$select_id.'">'.$select_label;
				$devolver .= '<input class="checkbox-nice" type="checkbox" '.$seleccionado.' name="caracteristicas[]" value="'.$select_id.'" id="checkbox-caracteristica-'.$select_id.'"/>';
				$devolver .= '<span class = "checkmark"></span>';
			$devolver .= '</span>';
		$devolver .= '</label>';
	}
	$devolver .= '</div> <!-- caja-contenedora-caracteristicas -->';
	return $devolver;
}


//attachment helper function   
function insert_attachment( $file_handler, $post_id, $set_thumb = false )
{
    if ( UPLOAD_ERR_OK !== $_FILES[ $file_handler ]['error'] )
        return false; 

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $attach_id = media_handle_upload( $file_handler, $post_id );

    //set post thumbnail (featured)
    if ( $attach_id && $set_thumb )
        update_post_meta( $post_id, '_thumbnail_id', $attach_id );

    return $attach_id;
}

/* Enfermedades: cambiar columnas */
// Agregar columnas personalizadas a la tabla de administración para el CPT "enfermedad"
function columnas_personalizadas_enfermedad($columns) {
    $columns['codigo'] = 'Código';
    $columns['nombre_cientifico'] = 'Nombre Científico';
    $columns['nombre_ingles'] = 'Nombre Inglés';
    $columns['descripcion'] = 'Descripción';
    return $columns;
}
add_filter('manage_enfermedad_posts_columns', 'columnas_personalizadas_enfermedad');

// Rellenar los datos de las columnas personalizadas en la tabla de administración para el CPT "enfermedad"
function datos_columnas_personalizadas_enfermedad($column, $post_id) {
    switch($column)
    {
	    case 'codigo':
		    echo get_post_meta($post_id, 'enfermedad_codigo', true);
			break;
	    case 'nombre_cientifico':
		    echo get_post_meta($post_id, 'nombre_cientifico', true);
			break;
	    case 'nombre_ingles':
		    echo get_post_meta($post_id, 'nombre_ingles', true);
			break;
	    case 'descripcion':
		    echo get_post_meta($post_id, 'descripcion', true);
			break;
    }
}
add_action('manage_enfermedad_posts_custom_column', 'datos_columnas_personalizadas_enfermedad', 10, 2);


// 20240626 : metadescripcion de variedades automatica
add_filter('wpseo_metadesc', 'yoast_seo_custom_meta_description');

function yoast_seo_custom_meta_description($description) {
    if (is_singular('variedad')) {
        global $post;
        $meta_description = get_field('informacion_extra', $post->ID);

        if ($meta_description) {
            $meta_description = wp_strip_all_tags($meta_description);
			return esc_attr($meta_description);
        }
    }
    return $description;
}
