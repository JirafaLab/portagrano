<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package portagrano2023
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('jky-orejas-ads'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'portagrano2023' ); ?></a>

	<header id="masthead" class="site-header">
		<div class = "container">
			<?php echo do_shortcode('[google-translator]'); ?>
			<nav id="site-navigation" class="main-navigation jky-display-flex elementos-espaciados">
				<div class="site-branding">
					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
					$portagrano2023_description = get_bloginfo( 'description', 'display' );
					if ( $portagrano2023_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $portagrano2023_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->
				<button class="menu-toggle jky-menu" aria-controls="primary-menu" aria-expanded="false"></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
			<?php 
				echo "<div class='capa-flotante dcha vademecum-header'>";
					$home = home_url( '/' )."vademecum-de-semillas/";
					if(wp_is_mobile())
					{
						echo "<a href='$home' title ='Ver el Vademécum de semillas'>";
							echo "Vademécum de semillas";
						echo "</a>";
					}
					/*
					else
					{
						echo "<a href='$home' title ='Ver el Vademécum de semillas'>";
							echo wp_get_attachment_image(645,'full',array('class'=>'flotando'));
						echo "</a>";
					}
					*/
					
				echo "</div>";
			?>
		</div>
	</header><!-- #masthead -->
	<section id="precontent">
		<div class = "container jky-display-flex banners-cabecera">
			<div class="columna banners">
				<?php 
					if(is_category( 'noticias' ) || is_single())
					{
						helperBanner('header-noticias',2);
					}
					else
					{
						if(is_front_page())
							helperBanner('header-home',2); 
						else
						{
							$page_id = get_the_ID();
							switch($page_id)
							{
								case 14814: // Especies de semillas
									helperBanner('header-especies',2);
									break;
								case 3274: // Empresas
									helperBanner('header-empresas',2);
									break;
								case 32838: // Contacto
									helperBanner('header-contacto',2);
									break;
							}
						}
					}
					
				?>
			</div>
			<div class="columna buscador">
				<?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
			</div>
		</div>
	</section>
