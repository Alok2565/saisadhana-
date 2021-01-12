<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php global $arisen_redux_optns; ?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'title' ); ?>">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!-- Theme shortcut Icon -->
	<?php 
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) :
			if(!empty($arisen_redux_optns['theme_favicon']['url'])) : ?>
				<link rel="shortcut icon" type="image/png" href="<?php echo esc_url($arisen_redux_optns['theme_favicon']['url']); ?>" />
	<?php endif; ?>	
	<?php endif; ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- PAGE LAYOUT STARTS HERE -->
 <?php
 $bgimage = '';
 $breadcrumb = 'hide-block-banner';
 if( !is_front_page() && !is_page() && !is_404() ) :  //if blog
	if( isset($arisen_redux_optns['blog_banner'])) :
		if( $arisen_redux_optns['blog_banner'] == true) :	
			$bgimage = 'header-img';
			$breadcrumb = '';
		else:
			$bgimage = '';
			$breadcrumb = 'hide-block-banner';
		endif;	
	endif;	
 endif;
?>

<div class="container-fluid full-width">
<div id="header-featured-image" class="page-top <?php echo esc_attr($bgimage); ?>">
<!-- HEADER SECTION -->
	<!--MENU BAR-->
	<nav id="top_nav" class="navbar navbar-default">
		<div class="container">
			<div class="nav-div">
			<div class="navbar-header page-scroll">
				<?php // check to see if the logo exists and add it to the page

				if(isset($arisen_redux_optns['theme_logo']['url']) && ($arisen_redux_optns['theme_logo']['url'] !='')) : ?>
					<div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home" class="navbar-brand">
						<img src="<?php echo esc_url($arisen_redux_optns['theme_logo']['url']); ?>" alt="<?php bloginfo( 'name' ) ?>" /></a>
					</div>
				<?php else : ?>
					<div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo( 'name' ) ?>" /></a></div>
				<?php endif; ?>

				<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only"><?php esc_html__( 'Toggle navigation', 'arisen' ) ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
				</div>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- Primary Nav Menu -->
			<?php if ( has_nav_menu( 'primary' ) ) : ?>

					<?php
						$backup_query = $wp_query;
						$wp_query = new WP_Query(array('post_type' => 'slider'));

						 wp_nav_menu( array(
							'menu'              => 'primary',
							'theme_location'    => 'primary',						
							'container'         => 'div',
							'menu_id'           => 'mainnav',
							'container_class'   => 'collapse navbar-collapse',
							'container_id'      => 'bs-example-navbar-collapse-1',
							'menu_class'        => 'nav navbar-nav navbar-right',
							'fallback_cb'       => 'arisen_navwalker::fallback',
							'walker'            => new arisen_navwalker())
						);
						$wp_query = $backup_query;
					?>
				<!-- /.navbar-collapse -->
			<?php endif; ?>
			</div>
		</div>
	</nav>

	<!-- BLOG HEADER -->
	<div class="container-fluid header-section <?php echo esc_attr($breadcrumb); ?>">
		<?php empty($breadcrumb) ? get_template_part( 'template-parts/header/blog-header' ) : ''; ?>
	</div>
</div><!-- END OF #HEADER SECTION -->