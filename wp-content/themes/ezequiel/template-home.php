<?php

/* Template Name: Home Template */

$home_slide_query = new WP_Query([
	'post_type'=> 'home_slide',
	'order'    => 'ASC'
]);
$post_query = new WP_Query([
	'post_type'=> 'post',
	'order'    => 'ASC',
	'posts_per_page' => 3

]);
$log_query = new WP_Query([
	'post_type'=> 'log',
	'order'    => 'ASC',
	'posts_per_page' => 2

]);

?>

<?php get_header(); ?>

<main role="main">

	<?php if($home_slide_query->have_posts()): ?>

		<div class="slider slick">

			<?php while($home_slide_query->have_posts()): $home_slide_query->the_post();

				$link_value = get_post_custom_values("link", $home_slide_query->post->ID);
				if(is_array($link_value) && count($link_value) == 1){
					$link_value = $link_value[0];
				}

				?>

				<div class="slide">
					<div style="background-image: url('<?php echo get_the_post_thumbnail_url($home_slide_query->post->ID); ?>');">
						<div class="container">

							<h1><?php the_title(); ?></h1>

							<?php the_content(); ?>

							<?php if(!empty($link_value)): ?>
								<a href="<?php echo $link_value; ?>" class="button button-yellow button-filled button-bold">Découvrir le projet</a>
							<?php endif; ?>

						</div>
					</div>
				</div>

			<?php endwhile; ?>

		</div>

	<?php endif; ?>

	<!-- section -->
	<section class="section section-home-page">

		<div class="container">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<div class="row">

					<div class="col-md-7">

						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php the_content(); ?>

							<?php comments_template( '', true ); // Remove if you don't want comments ?>

							<br class="clear">

							<?php edit_post_link(); ?>

						</article>
						<!-- /article -->

					</div>

					<div class="col-md-4 offset-md-1">

						<div class="sidebar sidebar-yellow home-sidebar">

							<h1>Carnet de bord</h1>
							<h3>Petit théâtre au bout du monde</h3>

							<?php if($log_query->have_posts()): ?>

								<div class="thumbs">

									<?php while($log_query->have_posts()): $log_query->the_post(); ?>

										<div class="thumb">
											<h4 class="title"><?php echo $log_query->post->post_title; ?></h4>
											<span class="date">Publié le <?php echo get_the_time("j F Y", $log_query->post->ID); ?></span>
											<div class="thumbnail">
												<div style="background-image:url('<?php echo get_the_post_thumbnail_url($log_query->post->ID); ?>');"></div>
											</div>
											<a href="<?php echo get_permalink($log_query->post->ID); ?>" class="button button-black-on-yellow">Lire</a>
											<div class="clear"></div>
										</div>

									<?php endwhile; ?>

								</div>

							<?php endif; ?>

						</div>

					</div>

				</div>

			<?php endwhile; ?>

			<?php else: ?>

				<!-- article -->
				<article>

					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

				</article>
				<!-- /article -->

			<?php endif; ?>

		</div>

	</section>
	<!-- /section -->

	<section class="section section-black section-home-news">

		<div class="container">

			<div class="section-title">
				<h1 class="title">Actualités</h1>
			</div>

			<div class="row">

				<?php if($post_query->have_posts()): ?>

					<?php while($post_query->have_posts()): $post_query->the_post(); ?>

						<div class="col-md-4<?php if($post_query->current_post > 0){ echo " d-none d-md-block"; } ?>">
							<div class="thumb thumb-full">
								<div class="thumbnail">
									<div style="background-image:url('<?php echo get_the_post_thumbnail_url($post_query->post->ID); ?>');"></div>
								</div>
								<h4 class="title"><?php echo $post_query->post->post_title; ?></h4>
								<span class="date">Publié le <?php echo get_the_time("j F Y", $post_query->post->ID); ?></span>
								<p class="desc"><?php echo $post_query->post->post_excerpt; ?></p>
								<a href="<?php echo get_permalink($post_query->post->ID); ?>" class="button button-white">Lire</a>
								<div class="clear"></div>
							</div>
						</div>

					<?php endwhile; ?>

				<?php endif; ?>

			</div>

		</div>

	</section>

	<section class="section">

		<div class="container">

			<div class="section-title">
				<h1 class="title">Le petit théâtre du bout du monde opus II</h1>
			</div>

			<div class="quote">
				<p>Ce titre évocateur de pays lointains nous parle du monde d'aujourd'hui, d'ici même, au milieu de nos utopies. D'ici même au bout d'un rêve au milieu de nos renoncements.</p>
				<div class="author">Ezéquiel Garcia-Romeu</div>
				<span class="clear"></span>
			</div>

		</div>

	</section>

</main>

<?php get_footer(); ?>
