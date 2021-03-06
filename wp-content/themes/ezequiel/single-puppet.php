<?php

$puppets_query = new WP_Query([
	'post_type'=> 'puppet',
	'order'    => 'ASC',
	'posts_per_page' => 4
]);

get_header();

?>

<main role="main">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<section class="section">

			<div class="container">

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- post title -->
					<h2 class="page-title"><?php the_title(); ?></h2>
					<!-- /post title -->

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

		<section class="section section-yellow">

			<div class="container">

				<div class="section-title">
					<h1 class="title">Fiche descriptive & participative</h1>
					<h3 class="sub-title"><?php the_title(); ?></h3>
				</div>

				<ul class="comments">
					<?php wp_list_comments([
						'per_page' => 10,
						'reverse_top_level' => false
					], get_comments([
						'post_id' => get_the_ID()
					])); ?>
				</ul>

                <br>

				<?php comment_form([
					'comment_notes_before' => null,
					'title_reply' => null,
					'title_reply_before' => null,
					'title_reply_after' => null,
				]); ?>

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

			<h2>Découvrez également d'autres marionnettes</h2>

			<div class="row">

				<?php if($puppets_query->have_posts()): ?>

					<?php while($puppets_query->have_posts()): $puppets_query->the_post(); ?>

						<div class="col-md-3">
							<div class="thumb thumb-full">
								<div class="thumbnail thumbnail-square">
									<div style="background-image:url('<?php echo get_the_post_thumbnail_url($puppets_query->post->ID); ?>');"></div>
								</div>
								<h4 class="title"><?php echo $puppets_query->post->post_title; ?></h4>
								<a href="<?php echo get_permalink($puppets_query->post->ID); ?>" class="button">Voir</a>
								<div class="clear"></div>
							</div>
						</div>

						<div class="w-100 d-md-none"></div>

					<?php endwhile; ?>

				<?php endif; ?>

			</div>

		</div>

	</section>

</main>

<?php get_footer(); ?>
