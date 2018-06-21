<?php

/* Template Name: Project Page Template */

$log_query = new WP_Query([
	'post_type'=> 'log',
	'order'    => 'ASC',
	'posts_per_page' => 3

]);

?>

<?php get_header(); ?>

<main role="main">

	<!-- section -->
	<section class="section section-project-page">

		<div class="container">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<h1 class="page-title"><?php the_title(); ?></h1>

				<div class="row">

					<div class="col-md-7">

						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php the_content(); ?>

							<br class="clear">

							<?php edit_post_link(); ?>

						</article>
						<!-- /article -->

					</div>

					<div class="col-md-4 offset-md-1">

						<div class="sidebar">

							<h1>En savoir +</h1>
							<h3>sur le projet</h3>

							<?php ez_project_nav(); ?>

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

	<section class="section section-yellow section-project-logs">

		<div class="container">

			<div class="section-title">
				<h1 class="title">Suivez l'avancée du projet</h1>
				<h3 class="sub-title">Grâce au carnet de bord</h3>
			</div>

			<div class="row thumbs-row">

				<?php if($log_query->have_posts()): ?>

					<?php while($log_query->have_posts()): $log_query->the_post(); ?>

						<div class="col-md-4<?php if($log_query->current_post > 0){ echo " d-none d-md-block"; } ?>">
							<div class="thumb">
								<h4 class="title"><?php echo $log_query->post->post_title; ?></h4>
								<span class="date">Publié le <?php echo get_the_time("j F Y", $log_query->post->ID); ?></span>
								<div class="thumbnail">
									<div style="background-image:url('<?php echo get_the_post_thumbnail_url($log_query->post->ID); ?>');"></div>
								</div>
								<a href="<?php echo get_permalink($log_query->post->ID); ?>" class="button button-black-on-yellow">Lire</a>
								<div class="clear"></div>
							</div>
						</div>

					<?php endwhile; ?>

				<?php endif; ?>

			</div>

		</div>

	</section>

</main>

<?php get_footer(); ?>
