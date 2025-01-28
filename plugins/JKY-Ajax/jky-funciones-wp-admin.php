<?php
/*
Plugin Name: JKY: Panel de administración
Plugin URI: 
Description: Cambios en el BackOffice: personalizaciones y adiciones <strong>NO BORRAR NI DESACTIVAR</strong>
Author: Juanky Castillo
Version: 
Author URI: 
*/


/*
Añade una entrada en el Menú Admnistrador para las opciones
*/
define('APFSURL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
function jky_admin_menu_opciones()
{
	add_menu_page('Ajustes / Settings', // Titulo de la página
	'Ajustes / Settings',				// Titulo del Menú
	'administrator',					// Rol que puede acceder
	'jcp-admin-opciones',				// Id de la página de Opciones
	'jky_admin_pantalla_opciones',		// Función que va a pintar la página de opciones
	'dashicons-admin-generic'			//APFSURL.'/Jalea-logo-naranja-18px.png'
	);
}
add_action('admin_menu','jky_admin_menu_opciones');
/*
La función que pinta la página de opciones
*/
function jky_admin_pantalla_opciones()
{
?>
<div class = "wrap">
	<h1>Configuración personalizada / Custom settings</h1>
	<hr/>
	<form method = "POST" action = "options.php">
<?php
settings_fields('jcp-admin-opciones');
do_settings_sections('jcp-admin-opciones');
?>
	<h2>Redes Sociales</h2>
	<label>Facebook</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_facebook" 
			id = "jcp_opciones_rrss_facebook" 
			value = "<?php echo get_option('jcp_opciones_rrss_facebook'); ?>"/>
	<br/>
	<label>Twitter</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_twitter" 
			id = "jcp_opciones_rrss_twitter" 
			value = "<?php echo get_option('jcp_opciones_rrss_twitter'); ?>"/>
	<br/>
	<label>Linkedin</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_linkedin" 
			id = "jcp_opciones_rrss_linkedin" 
			value = "<?php echo get_option('jcp_opciones_rrss_linkedin'); ?>"/>
	<br/>
	<label>Instagram</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_instagram" 
			id = "jcp_opciones_rrss_instagram" 
			value = "<?php echo get_option('jcp_opciones_rrss_instagram'); ?>"/>
	<br/>
	<label>Youtube</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_yt" 
			id = "jcp_opciones_rrss_yt" 
			value = "<?php echo get_option('jcp_opciones_rrss_yt'); ?>"/>
	<br/>
	<label>WhatsApp</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_whatsapp" 
			id = "jcp_opciones_rrss_whatsapp" 
			value = "<?php echo get_option('jcp_opciones_rrss_whatsapp'); ?>"/>
	<br/>
	<label>WhatsApp 2</label>
	<br/>
		<input 
			type = "text" 
			name = "jcp_opciones_rrss_whatsapp_2" 
			id = "jcp_opciones_rrss_whatsapp_2" 
			value = "<?php echo get_option('jcp_opciones_rrss_whatsapp_2'); ?>"/>
	<br/>
	<hr/><hr/>
<?php
			submit_button();
?>
	</form>
</div>
<?php
}
/*
Función que registra las opciones del formulario en una lista blanca para que puedan ser guardadas
*/
function jcp_admin_opciones()
{
	// Redes Sociales
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_facebook','string');
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_twitter','string');
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_linkedin','string');
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_instagram','string');
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_yt','string');
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_whatsapp','string');
	register_setting('jcp-admin-opciones','jcp_opciones_rrss_whatsapp_2','string');
}
add_action('admin_init','jcp_admin_opciones');

/* Zona wp-admin */
// Quitar cosas del escritorio
function remove_dashboard_widgets()
{
    global $wp_meta_boxes;
  
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/* menu Bar */
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar)
{
	$objeto = get_queried_object();
	$url = dameEnlaceVerVentas();
	
	$txt = 'Buscador de Variedades';
	$admin_bar->add_menu(array(
        'id'    => 'admin-bar-ver-ventas',
        'title' => $txt,
        'href'  => $url,
        'meta'  => array('title' => $txt)));
<<<<<<< Updated upstream
    if(userEsAdmin()[0]) {
	$txt = 'Registrar Variedad';
    $admin_bar->add_menu( array(
=======
	$user_data = userEsAdmin(); // Obtienes los datos del usuario
	if ($user_data && array_intersect($user_data[2], ['administrator', 'editor_de_variedades'])) {
		$txt = 'Registrar Variedad';
    	$admin_bar->add_menu( array(
>>>>>>> Stashed changes
        'id'    => 'admin-bar-nueva-venta',
        'title' => $txt,
        'href'  => get_home_url()."/crear-editar-variedad/?id_variedad=0",
        'meta'  => array('title' => $txt)));
	}
<<<<<<< Updated upstream
	if(userEsAdmin()[0] == true) {
=======
	if ($user_data && array_intersect($user_data[2], ['administrator', 'editor_de_variedades'])) {
>>>>>>> Stashed changes
		if(is_page(258)) // Crear editar variedad
		{
			$idventa = empty($_GET['id_variedad'])? "0" : $_GET['id_variedad'];
			if($idventa != "0")
			{
				
				$admin_bar->add_menu( array(
					'id'    => 'admin-bar-editar-semilla',
					'title' => 'Editar en Wordpress',
					'href'  => get_home_url()."/wp-admin/post.php?post=$idventa&action=edit",
					'meta'  => array('title' => "Editar en Wordpress")));
				
				$url = get_permalink($idventa);
				$admin_bar->add_menu( array(
					'id'    => 'admin-bar-ver-semilla',
					'title' => 'Ver como visitante',
					'href'  => $url,
					'meta'  => array('title' => "Ver como visitante")));
			}
		}
		else
		{
			if($objeto->post_type == "variedad")
			{
				$idventa = get_the_ID();
				$txt = "Editar variedad";
				$admin_bar->add_menu( array(
					'id'    => 'admin-bar-editar-semilla',
					'title' => $txt,
					'href'  => get_home_url()."/crear-editar-variedad/?id_variedad=$idventa",
					'meta'  => array('title' => $txt)));
				$txt = "Editar en Wordpress";
				$admin_bar->add_menu( array(
					'id'    => 'admin-bar-editar-semilla-wordpress',
					'title' => $txt,
					'href'  => get_home_url()."/wp-admin/post.php?post=$idventa&action=edit",
					'meta'  => array('title' => $txt)));
			}		
		}
	}
}

function dameEnlaceVerVentas()
{
	$url = get_home_url().'/busqueda-avanzada/';
	/*
	$usuario_actual = userEsAdmin();
	if(in_array('administrator',$usuario_actual[2],true))
	{
		$url = get_home_url().'/ver-ventas-esinel/';
	}
	*/
	return $url;
}

function jky_register_sidebars()
{
    register_sidebar(array(
        "name" => "Espacio Footer",
        "id" => "widgets-footer",
        "class" => "clase-del-elemento",
        "before_widget" => "<div class='widget-footer'>",
        "after_widget" => "</div>",
        "before_title" => "<h2 class='widget-footer'>",
        "after_title" => "</h2>"
    ));
}
add_action('widgets_init','jky_register_sidebars');


add_filter('manage_posts_columns', 'jky_banners_posts_columns', 5);
add_action('manage_posts_custom_column', 'jky_banners_posts_columns_contenido', 5, 2); 
function jky_banners_posts_columns($defaults){
    $defaults['imagen'] = "Imagen";
    return $defaults;
}
 
function jky_banners_posts_columns_contenido($column_name, $id){
    if($column_name === 'imagen'){
        echo '<div class="foto-en-tabla">';
        	the_post_thumbnail('thumbnail');
        echo '</div>';
    }
}


/**
	
	Añadir soporte para columnas de Taxonomia y Ordenables
*/
add_action( 'restrict_manage_posts', 'filter_variedades_by_taxonomies' , 99, 2);
/* Filter CPT via Custom Taxonomy */
/* https://generatewp.com/filtering-posts-by-taxonomies-in-the-dashboard/ */

function filter_variedades_by_taxonomies( $post_type, $which ) {

	// Apply this to a specific CPT
	if ( 'variedad' !== $post_type )
	    return;
	
	// A list of custom taxonomy slugs to filter by
	$taxonomies = array( 'especie', 'caracteristica', 'empresa' );
	
	foreach ( $taxonomies as $taxonomy_slug ) {
	
	    // Retrieve taxonomy data
	    $taxonomy_obj = get_taxonomy( $taxonomy_slug );
	    $taxonomy_name = $taxonomy_obj->labels->name;
	
	    // Retrieve taxonomy terms
	    $terms = get_terms( $taxonomy_slug );
	
	    // Display filter HTML
	    echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
	    echo '<option value="">' . sprintf( esc_html__( 'Mostrar todas las %s', 'text_domain' ), $taxonomy_name ) . '</option>';
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

add_action( 'restrict_manage_posts', 'filter_enfermedades_by_especies' , 100, 2);
function filter_enfermedades_by_especies( $post_type, $which ) {

	// Apply this to a specific CPT
	if ( 'enfermedad' !== $post_type )
	    return;
	
	// A list of custom taxonomy slugs to filter by
	$taxonomies = array( 'especie');
	
	foreach ( $taxonomies as $taxonomy_slug ) {
	
	    // Retrieve taxonomy data
	    $taxonomy_obj = get_taxonomy( $taxonomy_slug );
	    $taxonomy_name = $taxonomy_obj->labels->name;
	
	    // Retrieve taxonomy terms
	    $terms = get_terms( array(
		    'taxonomy' => $taxonomy_slug,
		    'orderby' => 'name',
		    'order' => 'ASC'
		));
	
	    // Display filter HTML
	    echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
	    echo '<option value="">' . sprintf( esc_html__( 'Mostrar todas las %s', 'text_domain' ), $taxonomy_name ) . '</option>';
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

// Función para ocultar elementos del menú
function ocultar_menu_para_roles() {
    // Verificar si el usuario es administrador
    if (!userEsAdmin()[0]) { // Llama a la función userEsAdmin una vez
        // Obtener el rol del usuario
        $user = wp_get_current_user();
        $user_roles = $user->roles;

        // Ocultar elementos para Redactores y Suscriptores
        if (in_array('redactor', $user_roles) || in_array('suscriptor', $user_roles)) {
            remove_menu_page('edit-comments.php'); // Eliminar la página de comentarios del menú
            remove_menu_page('wpcf7');  // Eliminar la página de Contact Form 7 del menú
        }
    }
}

// Función para ocultar elementos de la barra de administración
function ocultar_barra_para_roles($wp_admin_bar) {
    // Verificar si el usuario es administrador
    if (!userEsAdmin()[0]) { // Llama a la función userEsAdmin una vez
        // Obtener el rol del usuario
        $user = wp_get_current_user();
        $user_roles = $user->roles;

        // Ocultar elementos de la barra de administración para Redactores y Suscriptores
        if (in_array('redactor', $user_roles) || in_array('suscriptor', $user_roles)) {
            $wp_admin_bar->remove_node('comments');  // Eliminar el ítem "Comentarios"
            $wp_admin_bar->remove_node('wpcf7');  // Eliminar el nodo de Contact Form 7
            $wp_admin_bar->remove_node('wp-logo');  // Eliminar el ícono de WordPress
            $wp_admin_bar->remove_node('wpseo-menu');  // Eliminar el icono de Yoast SEO

        }
    }
}

// Ejecutar la función en el hook admin_menu para ocultar elementos del menú
add_action('admin_menu', 'ocultar_menu_para_roles', 99);

// Ejecutar la función en el hook admin_bar_menu para ocultar elementos de la barra de administración
add_action('admin_bar_menu', 'ocultar_barra_para_roles', 999);


?>