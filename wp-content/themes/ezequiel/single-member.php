<?php

$member_query = new WP_Query([
	'post_type'=> 'member',
	'order'    => 'ASC',
	'posts_per_page' => 4
]);

get_header();

?>

<main role="main">

	<?php if (have_posts()): while (have_posts()) : the_post();

		$job_value = get_post_custom_values("job", get_the_ID());
		if(is_array($job_value) && count($job_value) == 1){
			$job_value = $job_value[0];
		}

		?>

		<section class="section">

			<div class="container">

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


					<div class="page-title-container">

						<!-- post title -->
						<h2 class="page-title"><?php the_title(); ?></h2>
						<!-- /post title -->

						<?php if(!empty($job_value)): ?>
							<div class="page-subtitle"><?php echo $job_value ?></div>
						<?php endif; ?>

					</div>

					<div class="article-thumbnail">

						<!-- post thumbnail -->
						<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
							<?php the_post_thumbnail(); // Fullsize image for the single post ?>
						<?php endif; ?>
						<!-- /post thumbnail -->

					</div>

					<?php the_content(); // Dynamic Content ?>

					<div class="clear"></div>

					<?php edit_post_link(); // Always handy to have Edit Post Links available ?>

				</article>
				<!-- /article -->

			</div>

		</section>

	<?php endwhile; ?>

	<?php else: ?>

		<section>

			<!-- article -->
			<article>

				<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

			</article>
			<!-- /article -->

		</section>

	<?php endif; ?>

	<section class="section section-puppets-puppets">

		<div class="container">

			<h2>Découvrez les autres membres de l'équipe</h2>

			<div class="row">

				<?php if($member_query->have_posts()): ?>

					<?php while($member_query->have_posts()): $member_query->the_post(); ?>

						<div class="col-3">
							<div class="thumb thumb-full">
								<div class="thumbnail">
									<div style="background-image:url('<?php echo get_the_post_thumbnail_url($member_query->post->ID); ?>');"></div>
								</div>
								<h4 class="title"><?php echo $member_query->post->post_title; ?></h4>
								<a href="<?php echo get_permalink($member_query->post->ID); ?>" class="button">En savoir +</a>
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
