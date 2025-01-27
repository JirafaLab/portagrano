<?php
/*
Plugin Name: JKY: Ajax para Web
Plugin URI: 
Description: Funciones AJAX para que funcione la plataforma <br/><strong>NO BORRAR NI DESACTIVAR</strong>
Author: Juanky Castillo
Version: 
Author URI: 
*/


/*
Añadir llamadas a funcion y Ajax
*/
// definida en jky-funciones-wp-admin
//define('APFSURL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );

function jky_enqueuescripts()
{
    wp_enqueue_script('AjaxJKY', APFSURL.'/js/AjaxJKY.js', array('jquery'));
    wp_localize_script('AjaxJKY', 'AjaxJKY', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    
    /* Select2 */
	wp_enqueue_style( 'jky-select2-css', "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" );
	wp_enqueue_script( 'jky-select2-js', "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js");	
    
    wp_enqueue_style('bootstrap_css','https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), '4.1.3'); 
	wp_enqueue_script('popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array(), '1.14.3', true);
	wp_enqueue_script('bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array('jquery','popper_js'), '4.1.3', true);    
	
	/* 	SlickSlider */
	wp_enqueue_style( 'slick-slider-styles', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
	wp_enqueue_style( 'slick-slider-theme-styles', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css' );
	wp_enqueue_script('slick-slider-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', true );
}
add_action('wp_enqueue_scripts', 'jky_enqueuescripts');

// Adjuntar archivo CSS personalizado al panel de administración
function agregar_estilos_personalizados_admin() 
{
    // Condicion: si procede
    // if(Es admin pero no es Juanky)
    $ruta_css = APFSURL . '/style-admin.css';
    wp_enqueue_style('jky-funciones-wp-admin', $ruta_css, array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'agregar_estilos_personalizados_admin');



/*
jky_debug
*/
function jky_debug($texto)
{
	echo "<script>";
		echo "console.log('$texto');";
	echo "</script>";
}
function jky_debug_alert($texto)
{
	echo "<script>";
		echo "alert('$texto');";
	echo "</script>";
}
function jky_debug_h1($texto)
{
	echo "<h1 style = 'color:orange;'>$texto</h1>";
}
function jky_debug_vardump($variable)
{
	echo "<pre>";
		var_dump($variable);
	echo "</pre>";
}

add_shortcode('iconos_redes', 'devuelve_iconos_redes');
function devuelve_iconos_redes($parametros)
{
	$return_string = "<div class = 'iconos-redes-sociales'>";
	
	$valor = get_option('jcp_opciones_rrss_linkedin');
	if($valor != "")
	{
		$return_string .= "<span class = 'iconos-sociales linkedin'>";
			$return_string .= "<a href = '$valor' target = '_BLANK' title = 'Ir a Linkedin'>Linkedin</a>";
		$return_string .= "</span>";
	}
	$valor = get_option('jcp_opciones_rrss_instagram');
	if($valor != "")
	{
		$return_string .= "<span class = 'iconos-sociales instagram'>";
			$return_string .= "<a href = '$valor' target = '_BLANK' title = 'Ir a Instagram'>Instagram</a>";
		$return_string .= "</span>";
	}
	$valor = get_option('jcp_opciones_rrss_facebook');
	if($valor != "")
	{
		$return_string .= "<span class = 'iconos-sociales facebook'>";
			$return_string .= "<a href = '$valor' target = '_BLANK' title = 'Ir a Facebook'>Facebook</a>";
		$return_string .= "</span>";
	}
	$valor = get_option('jcp_opciones_rrss_twitter');
	if($valor != "")
	{
		$return_string .= "<span class = 'iconos-sociales twitter'>";
			$return_string .= "<a href = '$valor' target = '_BLANK' title = 'Ir a Twitter'>Twitter</a>";
		$return_string .= "</span>";
	}
	$valor = get_option('jcp_opciones_rrss_yt');
	if($valor != "")
	{
		$return_string .= "<span class = 'iconos-sociales youtube'>";
			$return_string .= "<a href = '$valor' target = '_BLANK' title = 'Ir a Youtube'>Youtube</a>";
		$return_string .= "</span>";
	}
	$valor = get_option('jcp_opciones_rrss_whatsapp');
	if($valor != "")
	{
		$return_string .= "<!-- Chat por WhatsApp -->";
		$return_string .= "<span class = 'iconos-sociales whatsapp'>";
			$return_string .= "<a href='https://wa.me/$valor' target='_BLANK' title='Hablar por WhatsApp' rel='noopener noreferrer'>Whatsapp</a>";
		$return_string .= "</span>";
	}
	$valor = get_option('jcp_opciones_rrss_whatsapp_2');
	if($valor != "")
	{
		$return_string .= "<!-- Chat por WhatsApp 2 -->";
		$return_string .= "<span class = 'iconos-sociales whatsapp whatsapp2'>";
			$return_string .= "<a href='https://wa.me/$valor' target='_BLANK' title='Hablar por WhatsApp' rel='noopener noreferrer'>Whatsapp</a>";
		$return_string .= "</span>";
	}
	$return_string .= "</div>";
	return $return_string;
}


/* Añadir a footer
	- PopUp Comercial
*/
add_action('wp_footer', 'jky_popups_footer');
function jky_popups_footer()
{
	?>
	<!-- SnackBack para Avisos -->
	<div id="snackbar"></div>
	
	<!-- PopUp Soporte -->
	<div id="modal-soporte-formulario" class="modal personalizadas mensaje fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<?php echo do_shortcode('[contact-form-7 id="312" title="Contacto Soporte"]'); ?>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
/* Interfaz Ajax */
add_action('wp_ajax_nopriv_dameDatosVentaPHPvistaCard','dameDatosVentaPHPvistaCard');
add_action('wp_ajax_dameDatosVentaPHPvistaCard','dameDatosVentaPHPvistaCard');
function dameDatosVentaPHPvistaCard($id = 0, $enlace_especie = "")
{
	$usuario_actual_capaz = userEsAdmin();
	$devolver = "";
	// fechas
	$fecha_a		= formateaFechaBDtoPHP(get_post_meta($id,'fecha_alta',true));
	$nombre			= get_the_title($id);
	$devolver .= "<div class = 'caja-venta venta-id-$id'>";
		$url	= get_permalink($id);
		
		$thumbnail_url = get_the_post_thumbnail_url($id, 'large');
		$devolver .= "<div class = 'venta-etiqueta cliente foto-variedad'>";
			if (has_post_thumbnail($id)) 
			{
				$devolver .= "<a href='$url'>";
					$devolver .= "<img src='$thumbnail_url' alt=''>";
				$devolver .= "</a>";
			}
		$devolver .= "</div>";
		$devolver .= "<div class = 'venta-datos-basicos'>";			
			$devolver .= "<span class = 'venta-etiqueta cliente nombre-variedad'>";
				// $devolver .= "<span>Nombre variedad</span>: ";
				$devolver .= "<a href='$url'>";
				$devolver .= $nombre;
				$devolver .= "</a>";
			$devolver .= "</span>";
			$especies_desordenadas		= get_the_terms($id,'especie');
			if(empty($especies_desordenadas))
				$especies_desordenadas = array();
			$especies = array();
			sort_terms_hierarchically($especies_desordenadas, $especies );
			$terminos = dameTerminosDeVariedad($especies);
			$cadena	= "";
			if(!empty($terminos[0]))
			{
				$terminos = empty($terminos)? 0 : $terminos;
				if($terminos[0] != null)
				{
					$termino = $terminos[0];
					
					$termino_nombre = get_term_field( 'name', $termino );
					$termino_enlace = get_term_link($termino, 'especie');
					$termino_slug	= get_term_field( 'slug', $termino );
					
					$cadena .= "<a class = 'enlace-especie esp-$termino_slug' href='$termino_enlace'>$termino_nombre</a>";
					
					if(isset($terminos[1]))
					{
						$termino = $terminos[1];
						
						$termino_nombre = get_term_field( 'name', $termino );
						//$termino_enlace = get_home_url()."/vademecum-semillas/?especie=".$termino;
						$termino_enlace = get_term_link( $termino, 'especie');
						$termino_slug	= get_term_field( 'slug', $termino );
						
						$cadena .= "<a class = 'enlace-especie esp-$termino_slug' href='$termino_enlace'>$termino_nombre</a>";
						//$cadena .= "&nbsp;";
						
						if(isset($terminos[2]))
						{
							$termino = $terminos[2];						
							$termino_nombre = get_term_field( 'name', $termino );
							//$termino_enlace = get_home_url()."/vademecum-semillas/?especie=".$termino;
							$termino_enlace = get_term_link( $termino, 'especie');
							$termino_slug	= get_term_field( 'slug', $termino );
							
							$cadena .= "<a class = 'enlace-especie esp-$termino_slug' href='$termino_enlace'>$termino_nombre</a>";
							// $cadena .= "&nbsp;";
							if(isset($terminos[3]))
							{
								$termino = $terminos[3];						
								$termino_nombre = get_term_field( 'name', $termino );
								//$termino_enlace = get_home_url()."/vademecum-semillas/?especie=".$termino;
								$termino_enlace = get_term_link( $termino, 'especie');
								$termino_slug	= get_term_field( 'slug', $termino );
								$cadena .= "<a class = 'enlace-especie esp-$termino_slug' href='$termino_enlace'>$termino_nombre</a>";
								// $cadena .= "&nbsp;";
							}
						}
					}
				}
			}
			$devolver .= "<span class = 'venta-etiqueta cliente especie'>";
				// $devolver .= "<span>Clasificación</span>: ";
				$devolver .= $cadena;
			$devolver .= "</span>";
			$devolver .= "<div class = 'semilla-caracteristicas'>";
				$dato = get_the_terms($id,'caracteristica');
				$cadena = "";
				if(!empty($dato))
				{
					foreach($dato as $caract)
					{
						//$enlace = get_term_link($caract);
						$idcarac 	= $caract->term_id;
						if($enlace_especie != "")
							$enlace = $enlace_especie."?caracteristicas[]=$idcarac";
						else
							$enlace = get_home_url()."/vademecum-semillas/?caracteristicas[]=$idcarac";
						$nombre = $caract->name;
						$slug	= $caract->slug;
						$cadena .= "<a class = 'enlace-caracteristicas car-$slug' href='$enlace'>$nombre</a>";
						// $cadena .= "&nbsp;";
					}
				}
				$devolver  .= '<span class="venta-etiqueta caracteristica">';
					//$devolver .= '<span>Características</span>: ';
					$devolver .= $cadena;
				$devolver .= '</span>';
			$devolver .= "</div> <!-- semilla-caracteristicas -->";
			$dato = get_the_terms($id,'empresa');
			$cadena = "";
			if(!empty($dato))
			{
				foreach($dato as $empresa)
				{
					$enlace = get_term_link($empresa);
					$nombre = $empresa->name;
					$slug	= $empresa->slug;
					$empresa_id = $empresa->term_id;
					$cadena .= "<a class = 'enlace-empresa intangible emp-$slug' onclick='dameDatosEmpresa($empresa_id)'>$nombre</a>";
					// $cadena .= "&nbsp;";
				}
			}
			/*
			$devolver .= "<span class = 'venta-etiqueta cliente empresa'>";
				$devolver .= "<span>Empresa</span>: ";
				$devolver .= $cadena;
			$devolver .= "</span>";
			*/
			if($usuario_actual_capaz[0] == true)
			{
				$devolver .= "<div class = 'venta-acciones'>";
					// $url	= get_permalink($id);
					$url = get_home_url()."/crear-editar-variedad/?id_variedad=$id";
					$devolver .= "<span class = 'venta-accion editar semilla'><a href = '$url' class = 'intangible'>Editar Ficha</a></span>";
				$devolver .= "</div> <!-- venta-acciones -->";
			}
		$devolver .= "</div> <!-- venta-datos-basicos -->";
	$devolver .= "</div> <!-- caja-venta -->";
		
	return $devolver;
}

add_action('wp_ajax_nopriv_dameDatosEnfermedadPorId','dameDatosEnfermedadPorId');
add_action('wp_ajax_dameDatosEnfermedadPorId','dameDatosEnfermedadPorId');
function dameDatosEnfermedadPorId()
{
	$devolver = array();
	$idenf = $_GET['id'];
	
	if(!empty($idenf))
	{
	    $devolver [0] = get_post_field( 'post_title', $idenf);
	    $devolver [1] = get_post_meta($idenf,'nombre_cientifico',true);
	    $devolver [2] = get_post_meta($idenf,'nombre_ingles',true);
	    $devolver [3] = get_post_meta($idenf,'enfermedad_codigo',true);
	    //$devolver [4] = nl2br(get_post_meta($idenf,'descripcion',true));
		$devolver[4] = apply_filters('the_content', get_post_meta($idenf,'descripcion',true));
	}
	wp_send_json($devolver);
	wp_die();
}

add_action('wp_ajax_nopriv_dameDatosEmpresaPorId','dameDatosEmpresaPorId');
add_action('wp_ajax_dameDatosEmpresaPorId','dameDatosEmpresaPorId');
function dameDatosEmpresaPorId()
{
	$devolver = array();
	$idenf = $_GET['id'];
	
	$term = get_term( $idenf );

	// Verificar si se encontró la taxonomía
	if ( ! empty( $term ) && ! is_wp_error( $term ) ) 
	{
	    // Acceder a los datos de la taxonomía
	    $devolver[0] = $term->name;
        $devolver[1] = get_field('logo_foto_empresa', $term);
        $devolver[1] = $devolver[1]['url'];
        $devolver[2] = get_field('descripcion', $term);	    
	}
	wp_send_json($devolver);
	wp_die();
}


/*
	Formateador de fecha
*/
function formateaFechaBDtoPHP($datetimeFromMysql)
{
	$myFormatForView = "";
	$time = strtotime($datetimeFromMysql);
	if(!empty($time))
	{$myFormatForView = date("d/m/Y", $time);}
	return $myFormatForView;
}
function formateaFechaAAAAMMDDtoHTML($datetimeFromMysql)
{
	$myFormatForView = "";
	$time = strtotime($datetimeFromMysql);
	if(!empty($time))
	{$myFormatForView = date("Y-m-d", $time);}
	return $myFormatForView;
}

/*
	userEsAdmin
	el usuario es Admin?
	[0] true / false
	[1] ID
	[2] roles
*/
function userEsAdmin()
{
    $id = get_current_user_id();
    if (!empty($id))
    {
        $user = get_userdata($id);
        $user_roles = $user->roles;

        $devolver[0] = false;
        $devolver[1] = $id;
        $devolver[2] = $user_roles;

        // Lista de roles que consideramos como "admin"
        $roles_admin = ['administrator', 'director'];

        // Verificar si el usuario tiene alguno de los roles considerados como "admin"
        if (array_intersect($user_roles, $roles_admin))
        {
            $devolver[0] = true;
        }

        return $devolver;
    }
    return null;
}


/*
	Lista de ventas 
*/
function capaModoVista($resultados)
{
	echo '<div class = "resultados-encontrados">';
		echo '<span>Mostrando <span class = "cont-res">'.$resultados.'</span> variedades</span>';
	echo '</div><!-- Resultados -->';	
}
function filtrosVentas()
{
	$caja_filtros = '';
	echo "<form action='' method='GET' id='form-filtros-ventas'>";
		echo "<div class = 'fila-todos-filtros-jky'>";
		// Especies
		$padrep = $padreh = $padren = $padrenn = 0;
		$valorp = empty($_GET['especie1']) ? 0 : $_GET['especie1'];
		$padreh = $valorp;
		$valorh = empty($_GET['especie2']) ? 0 : $_GET['especie2'];
		$padren = $valorh;
		$valorn = empty($_GET['especie3']) ? 0 : $_GET['especie3'];
		$padrenn = $valorn;
		$valornn = empty($_GET['especie4']) ? 0 : $_GET['especie4'];
		
		$caja_filtros .= '<span class = "filtro-mensaje neutro">Especie: </span>';
		$caja_filtros .='<div id="caja-selects-especies" class = "w-full">';
			$caja_filtros .= pintaSemillaSelectEspecie('especie', $padrep, $valorp,'especie1', 'clasificacion1', true);
			$caja_filtros .= pintaSemillaSelectEspecie('especie', $padreh, $valorh,'especie2', 'clasificacion2');
			$caja_filtros .= pintaSemillaSelectEspecie('especie', $padren, $valorn,'especie3', 'clasificacion3');
			$caja_filtros .= pintaSemillaSelectEspecie('especie', $padrenn, $valornn,'especie4', 'clasificacion4');
		$caja_filtros .= '</div>';
	// Empresas
		if(userEsAdmin()[0])
		{
			$campo = get_terms('empresa',array('hide_empty' => false,'orderby'=>'meta_value'));
			if(isset($_GET['empresa'])){$seleccionados = $_GET['empresa'];}
			else{$seleccionados = "";}
			$caja_filtros .= helperSelectTax($campo,$seleccionados,'empresa','Empresas');
		}
	// Caracteristicas
		// Original
		// $campo = get_terms('caracteristica',array('hide_empty' => false,'orderby'=>'meta_value'));
		$seleccionados = isset($_GET['caracteristicas'])? $_GET['caracteristicas'] : [];
		// $caja_filtros .= helperNiceCheckBoxTax($campo,$seleccionados,'caracteristicas','Características');
		// Condicionado
		$caja_filtros .= '<div id="buscador-seccion-caracteristicas">';
			$caja_filtros .= '<span class = "filtro-mensaje neutro">Caracteristicas</span>';
			$caja_filtros .= filtrosDinamicosCaracteristicas($valorp, $seleccionados);
		$caja_filtros .= '</div>';
	// Enfermedades
		$caja_filtros .= '<div class="caja-filtro completo" id="colapse-enfermedades">';
			$caja_filtros .= '<span class="filtro-mensaje neutro">Resistencia a enfermedades:</span>';
			$caja_filtros .= '<div id="buscador-variedades-enfermedad">';
				$seleccionados = isset($_GET['enf_resistencia_alta'])? $_GET['enf_resistencia_alta'] : [];
				$caja_filtros .= pintaInputSemillaEnfermedadesBusqueda(0,'enf_resistencia_alta', $valorp, $seleccionados);
			$caja_filtros .= '</div>';
		$caja_filtros .= '</div>';
		
			echo "<div class = 'fila-todos-filtros-aplicados'>";
				echo $caja_filtros;		
				// Boton submit
				echo "<div class = 'caja-filtro botones'>";
					echo "<input type = 'submit' value = 'Filtrar' class = 'btn btn-sumbit'/>";
					// echo "<input type = 'reset' value = 'Reiniciar' class = 'btn btn-reset' onclick = 'reseteaBusqueda(\"form-filtros-ventas\")'/>";
					echo "<input type='reset' value='Reiniciar' class='btn btn-reset' onclick='window.location.href=\"" . home_url() . "/busqueda-avanzada/\"'/>";
				echo "</div>";
		echo "</div> <!-- caja-filtros-aplicados-todos -->";
	echo "</form>";
}
/* Helper para dibujar el select perteneciente a una Tax (multiple) */
function helperSelectTax($campo,$seleccionados,$name,$etiqueta)
{
	$devolver = "";
	$devolver .= '<div class="caja-filtro" id="colapse-'.$name.'">';
		$devolver .= '<span class = "filtro-mensaje neutro">'.$etiqueta.'</span>';
		$devolver .= '<select class = "posible-select2" name="'.$name.'[]" id="select-'.$name.'" multiple="multiple">';
		foreach ($campo as $seleccion)
		{
			$select_id		= $seleccion->term_id;
			$select_label	= $seleccion->name;
			if(empty($seleccionados))
			{
				$devolver 		.= '<option value="'.$select_id.'">'.$select_label.'</option>';
			}
			else
			{
				$devolver 		.= in_array($select_id,$seleccionados)? '<option value="'.$select_id.'" selected="selected">'.$select_label.'</option>' : '<option value="'.$select_id.'">'.$select_label.'</option>';	
			}
		}
		$devolver .= '</select>';
		$devolver .= '<span class = "filtro-mensaje consejo">(vacío para todos / puede elegir varios)</span>';
	$devolver .= '</div>';
	return $devolver;
}
/* Helper para dibujar modo checkbox nice */
function helperNiceCheckBoxTax($campo,$seleccionados,$name,$etiqueta)
{
	$devolver = "";
	$devolver .= '<div class="caja-filtro completo" id="colapse-'.$name.'">';
		$devolver .= '<span class = "filtro-mensaje neutro">'.$etiqueta.'</span>';
		foreach ($campo as $seleccion)
		{
			$select_id		= $seleccion->term_id;
			$select_label	= $seleccion->name;
			$select_slug	= $seleccion->slug;
			$checked = '';
			if(in_array($select_id,$seleccionados))
			{
				$checked = 'checked="checked"';
			}
			$devolver .= '<label class="container-nice-none">';
			//$devolver .= '<label class="container-nice">';
				$devolver .= '<span class = "venta-icono estado '.$select_slug.'">'.$select_label.' <span class = "cuantos-estado" id = "cuantos-estado-'.$select_id.'"></span>';
					$devolver .= '<input class="checkbox-nice" type="checkbox" '.$checked.' name="'.$name.'[]" value="'.$select_id.'" id="checkbox-estado-'.$select_id.'"/>';
					$devolver .= '<span class = "checkmark"></span>';
				$devolver .= '</span>';
			$devolver .= '</label>';

		}
		//$devolver .= '<span class = "filtro-mensaje consejo">(vacío para todos / puede elegir varios)</span>';
	$devolver .= '</div>';
	return $devolver;
}
/* Helper para dibujar Radio Orden */
function helperRadioOrden($seleccionado,$value,$etiqueta)
{
	$devolver = '';
	$devolver .= '<div class="caja-fecha">';
		$devolver .= '<div class="caja-fecha-paquete orden-'.$value.'">';
			$devolver .= '<span class = "filtro-mensaje neutro">Ordenar por <strong>'.$etiqueta.': </strong></span>';
			$checked = $seleccionado == $value.'-asc'? "checked" : "";
			$devolver .= '<label class = "orden orden-asc"><input type="radio" class = "btn-orden orden-asc" name="orden" value="'.$value.'-asc" '.$checked.' id="'.$value.'-asc"/> Ascendente</label>';
			$checked = $seleccionado == $value.'-desc'? "checked" : "";
			$devolver .= '<label class = "orden orden-desc"><input type="radio" class = "btn-orden orden-desc" name="orden" value="'.$value.'-desc" '.$checked.' id="'.$value.'-desc"/> Descendente</label>';
		$devolver .= '</div>';
	$devolver .= '</div>';
	return $devolver;
}
/* Helper para sacar servicios contratados de una venta */
function helperDameServiciosContratadosVenta($idventa)
{
	//$servicios_contratados = get_field('servicios_contratados_'.$campania_venta,$idventa);
	$servicios_contratados = get_post_meta($idventa,'servicios_contratados',true);
	$trozos = explode(',', $servicios_contratados);
	$servicios_contratados = array();
	foreach($trozos as $trozo)
	{
		$servicios_contratados[] = $trozo;
	}
	return $servicios_contratados;
}

function cabeceraTablaVentas()
{
	$devolver = '<table id = "ver-ventas-tabla">';
		$devolver .= '<thead>';
			$devolver .= '<tr>';
				$devolver .= '<th class = "cabecera titular">Titular</th>';
				$devolver .= '<th class = "cabecera dni">DNI / NIE / CIF</th>';
				$devolver .= '<th class = "cabecera provincia">Provincia</th>';
				$devolver .= '<th class = "cabecera estado">Estado</th>';
				$devolver .= '<th class = "cabecera campania">Campaña</th>';
				$devolver .= '<th class = "cabecera cups">CUPS y otros</th>';
				//$devolver .= '<th class = "cabecera potencia">Potencia</th>';
				//$devolver .= '<th class = "cabecera consumo">Consumo</th>';
				$devolver .= '<th class = "cabecera servicios">Servicios</th>';
				$devolver .= '<th class = "cabecera fechas">Fechas</th>';
				//$devolver .= '<th>Acciones</th>';
			$devolver .= '</tr>';
		$devolver .= '</thead>';
		$devolver .= '<tbody>';
	return $devolver;
}
function footerTablaVentas()
{
		$devolver = '</tbody>';
	$devolver .= '</table> <!-- Fin tabla: ver-ventas-tabla -->';
	return $devolver;
}


/* Recortar Excerpt */
function jky_excerpt_length($length){ return 30; } add_filter('excerpt_length', 'jky_excerpt_length');

/* Buscar que "empiecen por la letra" */
function jky_posts_where( $where, $query ) {
    global $wpdb;

    $starts_with = esc_sql( $query->get( 'starts_with' ) );

    if ( $starts_with ) {
        $where .= " AND $wpdb->posts.post_title LIKE '$starts_with%'";
    }

    return $where;
}
add_filter( 'posts_where', 'jky_posts_where', 10, 2 );




function helperArchivoNoticias($titulo,$anios_atras = 0)
{
	?>
	<div class="jky-widget">
		<div class="cabecera">
			<h2 class="fuente-tipo-ff fuente-size-18 fuente-estilo-bold"><?php echo $titulo ?></h2>
		</div>
		<div class="cuerpo">
	<?php
	if($anios_atras == 0)
		$anios_atras = 50;
	$hoy = date("Y");
	
	for($anios_atras; $anios_atras > 0; $anios_atras--)
	{
		$args = array(
		    'type' => 'monthly',
		    'format' => 'custom',
		    'before' => '<span class="archivo mes">',
		    'after' => '</span>',
		    'show_post_count' => false,
		    'echo' => false,
		    'post_type' => 'post',
		    'in_year'		=> $hoy,
		    
		);
		$archives = wp_get_archives($args);
		if(!empty($archives))
		{
			//$archives = str_replace('</li>', '</li></ul>', $archives);
			echo "<span class='archivo anio'>Año $hoy</span>";
			//echo str_replace('<li>', '<li><strong>', $archives);
			echo $archives;
		}
		$hoy = intval($hoy) - 1;
	}
	?>
		</div>
	</div>
	<?php
}

// Modificación para poder listar por años
add_filter( 'getarchives_where', function ( $where, $parsed_args ) {
    if ( ! empty( $parsed_args['in_year'] ) ) {
        $year = absint( $parsed_args['in_year'] );
        $where .= " AND YEAR(post_date) = $year";
    }
    return $where;
}, 10, 2 );

function restringir_acceso_paginas_usurios_noadmin() {
    // Definimos un array con los slugs o IDs de las páginas que queremos restringir
    $paginas_restringidas = array('test', 'crear-editar-variedad'); // Slugs o IDs de las páginas

    // Verificamos si estamos en alguna de las páginas dentro del array
    if (is_page($paginas_restringidas)) {
        // Verificamos si el usuario NO es administrador
        if (!current_user_can('administrator')) {
            // Redirigimos a otra página (por ejemplo, la página de inicio)
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('template_redirect', 'restringir_acceso_paginas_usurios_noadmin');

?>