<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'after_open_body_tag' ); ?>

	<?php get_template_part( 'inc_mobile_nav' ); ?>

	<div id="page">

		<div class="container">
			
			<header id="header">

				<div class="row">

					<div id="logo" class="col-sm-6 <?php logo_class(); ?>">
						<?php ci_e_logo( '<h1>', '</h1>' ); ?>
						<?php ci_e_slogan( '<p>', '</p>' ); ?>
					</div>

					<?php if ( is_active_sidebar( 'header-widgets' ) ) : ?>
					<div class="col-sm-6">
						<div class="widgets-head">
							<?php dynamic_sidebar( 'header-widgets' ); ?>
						</div>
					</div>
					<?php endif; ?>

				</div>

				<div class="row">

					<nav id="nav" class="nav col-xs-12">
						
						<?php
							if ( has_nav_menu( 'ci_main_menu' ) ) {
								wp_nav_menu( array(
									'theme_location' => 'ci_main_menu',
									'fallback_cb'    => '',
									'container'      => '',
									'menu_id'        => 'navigation',
									'menu_class'     => 'navigation group'
								) );
							} else {
								wp_page_menu();
							}
						?>
					
					</nav><!-- /nav -->

				</div>

				<div id="mobilemenu"></div>

			</header><!-- /header -->	
