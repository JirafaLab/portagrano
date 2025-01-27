<?php
/**
 * Template Name: Buscador Semillas
*/

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejas();
	
$tax_query = $arg_acf = array();

$userEsAdmin = userEsAdmin();
$fecha_c_1   = empty($_GET['fecha_alta']) ? "1987-10-24" : $_GET['fecha_alta'];

$especie = !empty($_GET['especie4']) ? $_GET['especie4'] : 
           (!empty($_GET['especie3']) ? $_GET['especie3'] : 
           (!empty($_GET['especie2']) ? $_GET['especie2'] : 
           (!empty($_GET['especie1']) ? $_GET['especie1'] : 0)));

// $nombre         = empty($_GET['nombre']) ? "" : $_GET['nombre'];
$empresa        = empty($_GET['empresa']) ? 0 : $_GET['empresa'];
$caracteristicas= empty($_GET['caracteristicas']) ? 0 : $_GET['caracteristicas'];

$res_opciones	= empty($_GET['enfermedades-opciones']) ? 'todas' : $_GET['enfermedades-opciones'];
$res_alta       = empty($_GET['enf_resistencia_alta']) ? array() : $_GET['enf_resistencia_alta'];
/*
$res_media      = empty($_GET['res_media']) ? array() : $_GET['res_media'];
$tolerancia     = empty($_GET['tolerancia']) ? array() : $_GET['tolerancia'];
*/


$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

/* Especie */
if(!empty($especie))
{
    $tax_query[] = array(
    'relation' => 'AND', array(
        'taxonomy'  => 'especie',
        'field'     => 'id',
        'terms'     => $especie,
        'operator'  => "IN"));
}

/* Empresas */
if(!empty($empresa))
{
    $tax_query[] = array(
    'relation' => 'AND', array(
        'taxonomy'  => 'empresa',
        'field'     => 'id',
        'terms'     => $empresa,
        'operator'  => "IN"));
}

/* Características */
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

/* Enfermedades */
if ($res_opciones == 'todas') {
    if (!empty($res_alta)) {
        $arg_acf = array('relation' => 'AND'); // Relación 'AND' a nivel superior para cumplir con todas

        foreach ($res_alta as $enfermedad) {
            $arg_acf[] = array(
                'relation' => 'OR', // Relación 'OR' dentro del grupo de cada enfermedad
                array(
                    'key'     => 'enf_resistencia_alta',
                    'value'   => '"' . $enfermedad . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'enf_resistencia_intermedia',
                    'value'   => '"' . $enfermedad . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'enf_tolerancia',
                    'value'   => '"' . $enfermedad . '"',
                    'compare' => 'LIKE'
                )
            );
        }
    }
}
else {
    if (!empty($res_alta)) {
        $arg_acf = array('relation' => 'OR'); // Relación 'OR' a nivel superior para "al menos una"

        foreach ($res_alta as $enfermedad) {
            // Añadir las condiciones para cada enfermedad con 'OR'
            $arg_acf[] = array(
                'relation' => 'OR', // Relación 'OR' dentro de cada grupo de enfermedades
                array(
                    'key'     => 'enf_resistencia_alta',
                    'value'   => '"' . $enfermedad . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'enf_resistencia_intermedia',
                    'value'   => '"' . $enfermedad . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'enf_tolerancia',
                    'value'   => '"' . $enfermedad . '"',
                    'compare' => 'LIKE'
                )
            );
        }
    }
}

$query = new WP_Query(array(
    'post_type'         => 'variedad',
    'post_status'       => 'publish',
    // 'starts_with'       => $nombre,
    'posts_per_page'    => 21, // muestra 21 publicaciones por página
    'tax_query'         => $tax_query,
    'meta_query'        => $arg_acf,
    'orderby'           => 'title',
    'order'             => 'ASC',
    'paged'             => $paged // establece la página de resultados
));


// jky_debug_vardump($query);
filtrosVentas();
$contador_resultados = $query->found_posts;

echo capaModoVista($contador_resultados);
echo '<div class = "contenedor-ventas">';
	if($query->have_posts())
	{
		// Muestra la paginación
		echo '<div class="paginacion">';
			echo paginate_links(array('total' => $query->max_num_pages,'current' => $paged,'prev_text' => __('&laquo; Anterior'),'next_text' => __('Siguiente &raquo;')));
		echo '</div>';
		while($query->have_posts())
		{
			$query->the_post();
			$id 	= get_the_ID();
			echo dameDatosVentaPHPvistaCard($id);
		}
		// Muestra la paginación
		echo '<div class="paginacion">';
			echo paginate_links(array('total' => $query->max_num_pages,'current' => $paged,'prev_text' => __('&laquo; Anterior'),'next_text' => __('Siguiente &raquo;')));
		echo '</div>';
	}
	else
	{
		echo "<span class = 'resultados-encontrados ninguno'>Ninguna semilla encontrada con estos parámetros</span>";
	}
echo footerTablaVentas();
echo "</div> <!-- contenedor-ventas -->";
wp_reset_postdata();

		?>
		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
