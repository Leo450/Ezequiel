<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="l-header clear" role="banner">

				<div class="mobile-menu-button d-md-none">
					<span></span>
					<span></span>
					<span></span>
				</div>

				<div class="container">

					<div class="row align-items-center">

						<div class="col col-12 col-md-auto">
							<!-- logo -->
							<a class="l-logo" href="<?php echo home_url(); ?>">
								Le petit théâtre<br>du bout du monde
								<span>Opus II</span>
							</a>
							<!-- /logo -->
						</div>

						<div class="col col-12 col-md-auto">
							<!-- nav -->
							<nav class="nav d-none d-md-block" role="navigation">
								<?php html5blank_nav(); ?>
							</nav>
							<!-- /nav -->
						</div>

						<div class="d-none d-md-block col col-auto">
							<!-- socials -->
							<?php get_template_part('socials'); ?>
							<!-- /socials -->
						</div>

					</div>

				</div>

			</header>
			<!-- /header -->

			<?php if(!is_front_page()){ ?>
				<div class="breadcrumb">
					<div class="container">
						<?php custom_breadcrumbs(); ?>
					</div>
				</div>
			<?php } ?>
