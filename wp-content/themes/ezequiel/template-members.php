<?php

/* Template Name: Members Template */

$paged               = (get_query_var('paged')) ? get_query_var('paged') : 1;
$members_posts_query = new WP_Query([
	'post_type'=> 'member',
	'order'    => 'ASC',
	'posts_per_page' => 12,
	'paged' => $paged
]);

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

				<?php if($members_posts_query->have_posts()):

					$job_value = get_post_custom_values("job", $members_posts_query->post->ID);
					if(is_array($job_value) && count($job_value) == 1){
						$job_value = $job_value[0];
					}

					?>

					<div class="row">

						<div class="col-md-7">

							<div class="thumb thumb-alone">
								<div class="row align-items-center">

									<div class="col-5">
										<div class="thumbnail thumbnail-square">
											<div style="background-image: url('<?php echo get_the_post_thumbnail_url($members_posts_query->post->ID); ?>');"></div>
										</div>
									</div>
									<div class="col-7">
										<h4 class="title"><?php echo $members_posts_query->post->post_title; ?></h4>
										<?php if(!empty($job_value)): ?>
											<span class="legend"><?php echo $job_value ?></span>
										<?php endif; ?>
                                        <p class="desc"><?php echo $members_posts_query->post->post_excerpt; ?></p>
										<a href="<?php echo get_permalink($members_posts_query->post->ID); ?>" class="button">En savoir +</a>
									</div>

								</div>
							</div>

							<?php $members_posts_query->the_post(); ?>

							<div class="row">

								<?php while($members_posts_query->have_posts()): $members_posts_query->the_post();

									$job_value = get_post_custom_values("job", $members_posts_query->post->ID);
									if(is_array($job_value) && count($job_value) == 1){
										$job_value = $job_value[0];
									}

									?>

									<div class="col-6 col-md-4">

										<a href="<?php the_permalink(); ?>" class="thumb">
											<div class="thumbnail thumbnail-square">
												<div style="background-image:url('<?php echo get_the_post_thumbnail_url($members_posts_query->post->ID); ?>');"></div>
											</div>
											<h4 class="title"><?php echo $members_posts_query->post->post_title; ?></h4>
											<?php if(!empty($job_value)): ?>
												<span class="legend"><?php echo $job_value ?></span>
											<?php endif; ?>
										</a>

									</div>

									<?php if(($members_posts_query->current_post) % 2 == 0): ?>
										<div class="w-100 d-md-none"></div>
									<?php endif; ?>

									<?php if(($members_posts_query->current_post) % 3 == 0): ?>
										<div class="w-100 d-none d-md-block"></div>
									<?php endif; ?>

								<?php endwhile; ?>

							</div>

							<?php ez_pagination($members_posts_query, $paged); ?>

						</div>

						<div class="col-md-4 offset-md-1">

                            <div class="sidebar sidebar-yellow project-sidebar">

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

	<section class="section section-yellow section-project-logs">

		<div class="container">

			<div class="section-title">
				<h1 class="title">Suivez l'avancée du projet</h1>
				<h3 class="sub-title">Grâce au carnet de bord</h3>
			</div>

			<div class="row">

				<?php if($log_query->have_posts()): ?>

					<?php while($log_query->have_posts()): $log_query->the_post(); ?>

						<div class="col-md-4<?php if($log_query->current_post > 0){ echo " d-none d-md-block"; } ?>">
							<div class="thumb">
								<h4 class="title"><?php echo $log_query->post->post_title; ?></h4>
								<span class="date">Publié le <?php echo get_the_time("j F Y", $log_query->post->ID); ?></span>
								<div class="thumbnail">
									<div style="background-image:url('<?php echo get_the_post_thumbnail_url($log_query->post->ID); ?>');"></div>
								</div>
								<a href="<?php echo get_permalink($log_query->post->ID); ?>" class="button">En savoir +</a>
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
