<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package portagrano2023
 */

?>
	<section id="prefooter">
		<div class="container">
			<div id="caja-slider-empresas">
			<?php 
				$empresas = get_terms('empresa', array('orderby' => 'term_id', 'hide_empty' => false));
				if(!empty($empresas))
				{
					echo "<div id='slider-empresas'>";
					foreach($empresas as $empresa)
					{
						$enlace = get_term_link($empresa);
						$img = get_field('logo_foto_empresa', 'empresa_' . $empresa->term_id);
						if(!empty($img))
						{
							$img_alt = $img['alt'];
							$img = $img['url'];
							echo "<div class='slide-empresas'><a class='intangible' href='$enlace'><img src='$img' alt='$img_alt'/></a></div>";	
						}
						
					}
					echo "</div>";
				}
			?>
			</div>
<?php
if(is_front_page())
{
?>
			<div id="sobre-portagrano">
				<div class="jky-display-flex display-columna">
					<div class="jky-display-flex sobre-portagrano-txt">
						<h2>Sobre<br/> Portagrano</h2>
						<div>
							<?php
								//$texto = get_post_meta(636,'texto_sobre_portagrano',true);
								$texto = get_field('texto_sobre_portagrano',636);
								echo $texto;
							?>
						</div>
					</div>
					<div class="jky-display-flex sobre-portagrano-iconos">
						<?php
						for($i = 1; $i <= 5; $i++)
						{
							$cimg = 'icono_'.$i;
							$ctxt = 'texto_icono_'.$i;
							$img = get_post_meta(636, $cimg,true);
							$img = wp_get_attachment_image($img);
							$txt = get_post_meta(636, $ctxt,true);							
							echo '<div class="icono-prefooter">';
								echo $img;
								echo "<div>$txt</div>";
							echo '</div>';
						}
						?>						
					</div>
					<div id="banner-vademecum-footer">
						<?php
						$home = home_url( '/' )."contacto/";
						echo "<a href='$home' title ='Ver el Vademécum de semillas'>";
						if(!wp_is_mobile())
						{
							echo wp_get_attachment_image(42929,'full',array('class'=>'flotando'));	
						}
						echo "</a>";	
						?>
					</div>
				</div>
			</div>
<?php
}
?>
		</div>
	</section><!-- #prefooter -->

	<footer id="colophon" class="site-footer">
		<div class="container jky-display-flex footer">
			<?php dynamic_sidebar('widgets-footer'); ?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->


<!-- Modal Enfermedad -->
<div class="modal fade" id="ver-enfermedad" tabindex="-1" role="dialog" aria-labelledby="ver-enfermedad-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ver-enfermedad-label">Nombre Enfermedad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<span class='enfermedad-dato nombre-cientifico'>
      		Nombre científico: 
      		<span id='enf-nombre-cientifico'></span>
      	</span>
      	<span class='enfermedad-dato nombre-cientifico'>
      		Nombre Inglés: 
      		<span id='enf-nombre-ingles'></span>
      	</span>
      	<span class='enfermedad-dato nombre-cientifico'>
      		Código: 
      		<span id='enf-codigo'></span>
      	</span>
      	<span class='enfermedad-dato nombre-cientifico'>
      		Descripción: 
      	</span>
      	<div id='enf-descripcion'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>	

<!-- Modal Empresa -->
<div class="modal fade" id="ver-empresa" tabindex="-1" role="dialog" aria-labelledby="ver-empresa-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ver-empresa-label">Nombre Empresa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<img src="" id = "logo_foto_empresa"/>
      	<hr/>	
      	<div id = "descripcion">
	      	
      	</div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Imagenes -->
<div class="modal fade" id="ver-imagen" tabindex="-1" role="dialog" aria-labelledby="ver-imagen-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ver-imagen-label">Nombre imagen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<img src="" id = "imagen_ampliada"/>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<?php wp_footer(); ?>

</body>
</html>
