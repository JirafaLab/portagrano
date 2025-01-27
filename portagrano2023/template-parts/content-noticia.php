<?php
	$id		= get_the_ID();
	$titulo = get_the_title();
	$fecha	= get_the_date("d F Y");
	$texto	= get_the_excerpt();
	$imagen	= get_the_post_thumbnail($id,'full');
	$enlace	= get_the_permalink();
	$enlace_title = 'title="Ver noticia: '.$titulo.' - Portagrano.es"';
	$html_a = '<a class="ver-mas" href="'.$enlace.'" '.$enlace_title.'>Leer más</a>';
	
	echo '<div class="columna col-mitad">';
		echo  '<div class="caja-noticia destacada orden-'.$contador.'">';
			echo  '<div class="foto-noticia">'.'<a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$imagen.'</a>'.'</div>';
			echo  '<div class="fecha-noticia">'.$fecha.'</div>';
			echo  '<div class="titular-noticia">'.'<h3><a class="intangible" href="'.$enlace.'" '.$enlace_title.'>'.$titulo.'</a></h3>'.'</div>';
			echo  '<div class="texto-noticia">'.$texto.'</div>';
			echo  $html_a;
		echo  '</div>';	
	echo  '</div> <!-- col-mitad -->';
	$contador++;
?>