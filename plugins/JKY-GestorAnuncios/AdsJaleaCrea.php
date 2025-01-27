<?php
/*
Plugin Name: JKY: Gestor Anuncios Jalea Crea
Plugin URI: https://jaleacrea.com
Description: Plugin para gestionar anuncios: Tipo de contenido "Banners" y configuraciones de ubicación (asignarlos en Anuncios Home).
Version: 1.4.33
Author: Juanky Castillo
Author URI: juankycastillo@jaleacrea.com
License: GPLv2 o posterior
*/


/*
Añadir llamadas a funcion y Ajax
*/
define('ADSJALEA', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
function jky_enqueuescripts_ads()
{
    wp_enqueue_script('AdsJaleaCrea', ADSJALEA.'/js/AdsJaleaCrea.js', array('jquery'));
    wp_localize_script('AdsJaleaCrea', 'AdsJaleaCrea', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'jky_enqueuescripts_ads');

/*
Añade una entrada en el Menú Admnistrador para las opciones del slider
*/


	/*
	function jky_ads_menu_opciones()
	{
		add_menu_page('Gestión Banners', // Titulo de la página
		'Gestión Banners',				// Titulo del Menú
		'administrator',				// Rol que puede acceder
		'jcp-ads-opciones',				// Id de la página de Opciones
		'jky_ads_pantalla_opciones',	// Función que va a pintar la página de opciones
		ADSJALEA.'/assets/Jalea-logo-naranja-18px.png'
		);
	}
	add_action('admin_menu','jky_ads_menu_opciones');
	*/
	function jky_ads_menu_opciones() {
    // Añadir una página de menú en el área de administración
    add_menu_page(
        'Gestión Banners',            // Título de la página
        'Gestión Banners',            // Título del menú
        'administrator',              // Rol que puede acceder (mínimo un rol)
        'jcp-ads-opciones',           // ID de la página de opciones
        'jky_ads_pantalla_opciones',  // Función que renderiza la página de opciones
        ADSJALEA . '/assets/Jalea-logo-naranja-18px.png'  // URL del icono del menú
    );
}
 

// Hook para añadir la función al menú de administración
add_action('admin_menu', 'jky_ads_menu_opciones');


	
function jky_ads_custom_cpt()
{
	/*
	Post Type: Banners
	*/
	$labels = array(
		"name" => __( "Banners", "" ),
		"singular_name" => __( "Banner", "" ),
	);
	$args = array(
		"label" => __( "Banners", "" ),
		"labels" => $labels,
		"description" => "Banners",
		"public" => true,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => true,
		"capability_type" => "banner",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "banners", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 3,
		"menu_icon" => "dashicons-embed-photo",
		"supports" => array( "title", "editor", "thumbnail",'page-attributes'),
	);
	register_post_type( "banners", $args );	
}
add_action('init','jky_ads_custom_cpt');
/*
Creación de Taxonomias
*/
function jky_ads_custom_tax() 
{
	/**
	* Taxonomy: Posición
	*/
	$labels = array(
		"name" => __( "Posición", "" ),
		"singular_name" => __( "Posición", "" ),
	);
	$args = array(
		"label" => __( "Posición", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Posición",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'posicion', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "posicion", array("banners"), $args );
}
add_action('init','jky_ads_custom_tax');

	
/*
La función que pinta la página de opciones
*/
	function jky_ads_pantalla_opciones()
	{
		if (current_user_can('administrator') || current_user_can('director')) {
?>
	<div class = "wrap">
		<h1><img src = "<?php echo ADSJALEA.'/assets/Jalea-logo-naranja.png'; ?>"/> Anuncios Home</h1>
		<p>
			En esta página podemos configurar los anuncios mostrados en la <strong>Home (móvil / escritorio)</strong><br/>
			Por ahora son los mismos, pero en un futuro podríamos hacer que cada una tenga sus anuncios
		<hr/>
		<form method = "POST" action = "options.php">
<?php
settings_fields('jcp-ads-opciones');
do_settings_sections('jcp-ads-opciones');
?>
		<br/>
		<h2>Gestión de Banners</h2>
		<label>¿Aleatorios?</label>
		<br/>
			<?php 
				$anuncio = get_option('jcp_opciones_anuncios_random'); 
				$checked = "";
				if($anuncio == "on")
				{
					$checked = "checked='checked'";
				}
			?>
			<input 
				type = "checkbox" 
				name = "jcp_opciones_anuncios_random" 
				id = "jcp_opciones_anuncios_random" <?php echo $checked; ?>/>
		<br/>
		<label>Anuncios Orejas (Home)</label>
		<br/>
			<?php 
				$anuncio = get_option('jcp_opciones_anuncios_orejas'); 
				$checked = "";
				if($anuncio == "on")
				{
					$checked = "checked='checked'";
				}
			?>
			<input 
				type = "checkbox" 
				name = "jcp_opciones_anuncios_orejas" 
				id = "jcp_opciones_anuncios_orejas" <?php echo $checked; ?>/>
		<br/>
		<label>Oreja Izquierda (Home)</label>
		<br/>
			<input 
				type = "text" 
				name = "jcp_opciones_anuncios_oreja_izda" 
				id = "jcp_opciones_anuncios_oreja_izda" 
				value = "<?php echo get_option('jcp_opciones_anuncios_oreja_izda'); ?>"/>
		<br/>
		<label>Oreja Derecha (Home)</label>
		<br/>
			<input 
				type = "text" 
				name = "jcp_opciones_anuncios_oreja_dcha" 
				id = "jcp_opciones_anuncios_oreja_dcha" 
				value = "<?php echo get_option('jcp_opciones_anuncios_oreja_dcha'); ?>"/>
		<br/>
		<hr/><hr/>
		<label>Anuncios Orejas (Vademecum)</label>
		<br/>
			<?php 
				$anuncio = get_option('jcp_opciones_anuncios_orejas_vademecum'); 
				$checked = "";
				if($anuncio == "on")
				{
					$checked = "checked='checked'";
				}
			?>
			<input 
				type = "checkbox" 
				name = "jcp_opciones_anuncios_orejas_vademecum" 
				id = "jcp_opciones_anuncios_orejas_vademecum" <?php echo $checked; ?>/>
		<br/>
		<label>Oreja Izquierda (Vademecum)</label>
		<br/>
			<input 
				type = "text" 
				name = "jcp_opciones_anuncios_oreja_izda_vademecum" 
				id = "jcp_opciones_anuncios_oreja_izda_vademecum" 
				value = "<?php echo get_option('jcp_opciones_anuncios_oreja_izda_vademecum'); ?>"/>
		<br/>
		<label>Oreja Derecha (Vademecum)</label>
		<br/>
			<input 
				type = "text" 
				name = "jcp_opciones_anuncios_oreja_dcha_vademecum" 
				id = "jcp_opciones_anuncios_oreja_dcha_vademecum" 
				value = "<?php echo get_option('jcp_opciones_anuncios_oreja_dcha_vademecum'); ?>"/>
		<br/>
		<hr/><hr/>
<?php
				submit_button();
?>
		</form>
	</div>
<?php
		}
	}
/*
Función que registra las opciones del formulario en una lista blanca para que puedan ser guardadas
*/
	//function jky_post_slider_settings()
	function jcp_ads_opciones()
	{
		register_setting('jcp-ads-opciones', 'jcp_opciones_anuncios_random', array(
			'type' => 'boolean',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => false
		));
		// Orejas Home
		register_setting('jcp-ads-opciones', 'jcp_opciones_anuncios_orejas', array(
			'type' => 'boolean',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => false
		));
		register_setting('jcp-ads-opciones','jcp_opciones_anuncios_oreja_izda','string');
		register_setting('jcp-ads-opciones','jcp_opciones_anuncios_oreja_dcha','string');
		// Orejas Vademecum
		register_setting('jcp-ads-opciones', 'jcp_opciones_anuncios_orejas_vademecum', array(
			'type' => 'boolean',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => false
		));
		register_setting('jcp-ads-opciones','jcp_opciones_anuncios_oreja_izda_vademecum','string');
		register_setting('jcp-ads-opciones','jcp_opciones_anuncios_oreja_dcha_vademecum','string');		
	}
/*
Añadimos las opciones en el hook admin_init
*/
add_action('admin_init','jcp_ads_opciones');


// id:				Id del banner
// nuevapestana:	-1 : NO / 0 : valor del banner / 1 : SI
add_shortcode('dameBanner', 'dame_este_banner');
function dame_este_banner($atts)
{
	// normalize attribute keys, lowercase
	$atts = array_change_key_case((array)$atts, CASE_LOWER);
	// override default attributes with user attributes
	$wporg_atts = shortcode_atts(
		array(
			'id' => '732',
			'nuevapestana' => 0), 
		$atts);
	
	$id			= $atts['id'];
	$enlace		= get_post_meta($id,'enlace',true);
	$pestana	= get_post_meta($id,'pestana_nueva',true);
	$img		= get_the_post_thumbnail($id,'full');
	
	$target = "";
	$devolver = '<div class="anuncio anuncio-'.$id.'">';
	
	if($pestana == 'si')
	{$target = " target='_BLANK' ";}
	else
	{$target = " target='_SELF' ";}
	
		$devolver .= '<a class="intangible banner" href="'.$enlace.'"'.$target.'>';
			$devolver .= $img;
		$devolver .= '</a>';
	$devolver .= '</div>';
	
	return $devolver;
}

function dame_este_banner_oreja($id)
{
	$enlace		= get_post_meta($id,'enlace',true);
	$pestana	= get_post_meta($id,'pestana_nueva',true);
	$img		= get_the_post_thumbnail($id,'full');
	
	$target = " target='_SELF' ";
	$devolver = '<div class="anuncio anuncio-'.$id.' pestana-'.$pestana.'">';
	
	if($pestana == 'si')
	{
		$target = " target='_BLANK' ";
	}
		$devolver .= '<a class="intangible banner" href="'.$enlace.'"'.$target.'>';
			$devolver .= $img;
		$devolver .= '</a>';
	$devolver .= '</div>';
	
	return $devolver;
}

/* Tenemos que 
	recibir 'posicion' para buscar los banners de esa psoción
	recibir numero: cuantos sacamos
	los ordenamos por orden personalizado y así lo tenemos
	
	Tenemos en cuenta que si hay una opción: aleatorios los desordene, pero esto es absurdo
*/
function helperBanner($posicion, $cuantos)
{
	$aleatorio = get_option('jcp_opciones_anuncios_random');
	if($aleatorio == "on")
	{
		$args = array(
		    'post_type'         => 'banners',
		    'posts_per_page'    => $cuantos,
		    'post_status'       => 'publish',
		    'tax_query'         => array(
		        array(
		            'taxonomy' => 'posicion',
		            'field'    => 'slug',
		            'terms'    => $posicion
		        )
		    ),
		    'orderby'           => 'rand'
		);
	}
	else
	{
		$args = array(
	    'post_type' 		=> 'banners',
	    'posts_per_page'	=> $cuantos,
	    'post_status'		=> 'publish',
	    'tax_query'			=> array(
	        array(
	            'taxonomy' => 'posicion',
	            'field'    => 'slug',
	            'terms'    => $posicion)
	    ));
	}
	$query = new WP_Query($args);
	if($query->have_posts())
	{
		while($query->have_posts())
		{
			$query->the_post();
			$anuncio = get_the_ID();
			$shortcode = '[dameBanner id="'.$anuncio.'"]';
			if(!empty($anuncio)){echo do_shortcode($shortcode);}
		}
	}
	wp_reset_postdata();
}
function dameArrayBanners($posicion, $cuantos)
{
	$aleatorio = get_option('jcp_opciones_anuncios_random');
	$arraybanners = array();
	if($aleatorio == "on")
	{
		$args = array(
		    'post_type'         => 'banners',
		    'posts_per_page'    => $cuantos,
		    'post_status'       => 'publish',
		    'tax_query'         => array(
		        array(
		            'taxonomy' => 'posicion',
		            'field'    => 'slug',
		            'terms'    => $posicion
		        )
		    ),
		    'orderby'           => 'rand'
		);
	}
	else
	{
		$args = array(
	    'post_type' 		=> 'banners',
	    'posts_per_page'	=> $cuantos,
	    'post_status'		=> 'publish',
	    'tax_query'			=> array(
	        array(
	            'taxonomy' => 'posicion',
	            'field'    => 'slug',
	            'terms'    => $posicion)
	    ));
	}
	$query = new WP_Query($args);
	if($query->have_posts())
	{
		while($query->have_posts())
		{
			$query->the_post();
			$arraybanners[] = get_the_ID();
		}
		wp_reset_postdata();
	}
	return $arraybanners;
}
function pintaAnuncio($array, $indice)
{
	$id = $array[$indice];
	if(!empty($id))
	{
		$shortcode = '[dameBanner id="'.$id.'"]';
		echo do_shortcode($shortcode);
		$indice++;
	}
	return $indice;
}

/**
	
	Añadir soporte para columnas de Taxonomia y Ordenables
*/
add_action( 'restrict_manage_posts', 'filter_banners_by_taxonomies' , 99, 2);
/* Filter CPT via Custom Taxonomy */
/* https://generatewp.com/filtering-posts-by-taxonomies-in-the-dashboard/ */

function filter_banners_by_taxonomies( $post_type, $which ) {

// Apply this to a specific CPT
if ( 'banners' !== $post_type )
    return;

// A list of custom taxonomy slugs to filter by
$taxonomies = array( 'posicion' );

foreach ( $taxonomies as $taxonomy_slug ) {

    // Retrieve taxonomy data
    $taxonomy_obj = get_taxonomy( $taxonomy_slug );
    $taxonomy_name = $taxonomy_obj->labels->name;

    // Retrieve taxonomy terms
    $terms = get_terms( $taxonomy_slug );

    // Display filter HTML
    echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
    echo '<option value="">' . sprintf( esc_html__( 'Mostrar todas las posiciones', 'text_domain' ), $taxonomy_name ) . '</option>';
    foreach ( $terms as $term ) {
        printf(
            '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
            $term->slug,
            ( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
            $term->name,
            $term->count
        );
    }
    echo '</select>';
}

}


function ponOrejas()
{
	$orejas = get_option('jcp_opciones_anuncios_orejas');
	if($orejas == "on")
	{
		echo '<!-- Anuncios Orejas -->';
		$banner = get_option('jcp_opciones_anuncios_oreja_izda');
		echo '<div class="jky-oreja-ad oreja-izda">';
			echo dame_este_banner_oreja($banner);
		echo '</div>';

		$banner = get_option('jcp_opciones_anuncios_oreja_dcha');
		echo '<div class="jky-oreja-ad oreja-dcha">';
			echo dame_este_banner_oreja($banner);
		echo '</div>';
	}
}
function ponOrejasVademecum()
{	
	$orejas = get_option('jcp_opciones_anuncios_orejas_vademecum');
	if($orejas == "on")
	{
		echo '<!-- Anuncios Orejas -->';
		$banner = get_option('jcp_opciones_anuncios_oreja_izda_vademecum');
		echo '<div class="jky-oreja-ad oreja-izda">';
			echo dame_este_banner_oreja($banner);
		echo '</div>';

		$banner = get_option('jcp_opciones_anuncios_oreja_dcha_vademecum');
		echo '<div class="jky-oreja-ad oreja-dcha">';
			echo dame_este_banner_oreja($banner);
		echo '</div>';
	}
}