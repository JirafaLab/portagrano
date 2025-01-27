<?php
/**
 * Template Name: TEST
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container con-orejas">
<?php 
	ponOrejas();
?>
		<?php
$devolver = '';

$especie_id = 2116; // ID del término en la taxonomía 'especie'
$especie_term = get_term($especie_id, 'especie'); // Obtén el objeto del término usando su ID y el nombre de la taxonomía
$caracteristicas_para_filtrado = get_field('caracteristicas_para_filtrado', $especie_term);
if ($caracteristicas_para_filtrado) // Si hay caracterísitcas filtrables en esta taxonomía....
{
	$opciones_args = array(
		'hide_empty' 	=> false,
		'orderby' 		=> 'meta_value',
		'include' 		=> $caracteristicas_para_filtrado,
	);
	$campo = get_terms('caracteristica', $opciones_args);
	$seleccionados = isset($_GET['caracteristicas'])? $_GET['caracteristicas'] : [];
	$devolver = helperNiceCheckBoxTax($campo,$seleccionados,'caracteristicas','Filtrar por Características');
}
$devolver .= 'TEST';

echo $devolver;
		?>
		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
