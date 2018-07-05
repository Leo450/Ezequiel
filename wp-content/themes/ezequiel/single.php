<?php

$post_query = new WP_Query([
	'post_type'=> 'post',
	'order'    => 'ASC',
	'posts_per_page' => 3
]);

get_header(); ?>

<main role="main">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<section class="section">

			<div class="container">

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="page-title-container">

						<!-- post title -->
						<h2 class="page-title"><?php the_title(); ?></h2>
						<!-- /post title -->

						<!-- post details -->
						<span class="date"> Publié le <?php the_time('j F Y'); ?></span>
						<!-- /post details -->

					</div>

					<div class="article-thumbnail">

						<!-- post thumbnail -->
						<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
							<?php the_post_thumbnail(); // Fullsize image for the single post ?>
						<?php endif; ?>
						<!-- /post thumbnail -->

						<div class="meta">
							<?php the_tags(); ?>
						</div>

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
					<h1 class="title">Donnez nous votre avis sur cet article !</h1>
					<h3 class="sub-title">Evaluez l'article en nous laissant une note</h3>
				</div>

				<?php comment_form([
					'comment_notes_before' => null,
					'title_reply' => null,
					'title_reply_before' => null,
					'title_reply_after' => null,
				]); ?>

				<ul class="comments">
					<?php wp_list_comments([
						'per_page' => 10,
						'reverse_top_level' => false
					], get_approved_comments(get_the_ID())); ?>
				</ul>

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

	<section class="section section-single-articles">

		<div class="container">

			<h2>Découvrez d'autres articles associés</h2>

			<div class="row thumbs-row">

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
								<a href="<?php echo get_permalink($post_query->post->ID); ?>" class="button">Lire la suite</a>
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
