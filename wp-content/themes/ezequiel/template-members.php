<?php

/* Template Name: Members Template */

$paged               = (get_query_var('paged')) ? get_query_var('paged') : 1;
$members_posts_query = new WP_Query([
	'post_type'=> 'member',
	'order'    => 'ASC',
	'posts_per_page' => 12,
	'paged' => $paged
]);

?>

<?php get_header(); ?>

<main role="main">

	<!-- section -->
	<section class="section section-project-page">

		<div class="container">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<h1 class="page-title"><?php the_title(); ?></h1>

				<?php if($members_posts_query->have_posts()): ?>

					<div class="row">

						<div class="col-7">

							<div class="thumb thumb-alone">
								<div class="row align-items-center">

									<div class="col-5">
										<div class="thumbnail">
											<div style="background-image: url('<?php echo get_the_post_thumbnail_url($members_posts_query->post->ID); ?>');"></div>
										</div>
									</div>
									<div class="col-7">
										<h4 class="title"><?php echo $members_posts_query->post->post_title; ?></h4>
										<span class="legend">Artiste Scénographe</span>
										<p class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aspernatur consequatur, culpa deleniti dicta dignissimos dolorum eius exercitationem libero magnam nam non odit officia optio quam reiciendis repellendus. A, unde!</p>
										<a href="<?php echo get_permalink($members_posts_query->post->ID); ?>" class="button">En savoir +</a>
									</div>

								</div>
							</div>

							<?php $members_posts_query->the_post(); ?>

							<div class="row">

								<?php while($members_posts_query->have_posts()): $members_posts_query->the_post(); ?>

									<div class="col-4">

										<a href="<?php the_permalink(); ?>" class="thumb">
											<div class="thumbnail">
												<div style="background-image:url('<?php echo get_the_post_thumbnail_url($members_posts_query->post->ID); ?>');"></div>
											</div>
											<h4 class="title"><?php echo $members_posts_query->post->post_title; ?></h4>
											<span class="legend">Artiste Scénographe</span>
										</a>

									</div>

									<?php if(($members_posts_query->current_post) % 3 == 0): ?>
										<div class="w-100"></div>
									<?php endif; ?>

								<?php endwhile; ?>

							</div>

							<?php ez_pagination($members_posts_query, $paged); ?>

						</div>

						<div class="col-4 offset-1">

							<div class="sidebar">

								<h1>En savoir +</h1>
								<h3>sur le projet</h3>

								<?php ez_project_nav(); ?>

							</div>

						</div>

					</div>

				<?php endif; ?>

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

</main>

<?php get_footer(); ?>
