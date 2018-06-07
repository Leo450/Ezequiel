<?php

$member_query = new WP_Query([
	'post_type'=> 'member',
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

					<!-- post thumbnail -->
					<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
						<?php the_post_thumbnail(); // Fullsize image for the single post ?>
					<?php endif; ?>
					<!-- /post thumbnail -->

					<!-- post title -->
					<h2><?php the_title(); ?></h2>
					<!-- /post title -->

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
								<img src="<?php echo get_the_post_thumbnail_url($member_query->post->ID); ?>" alt="">
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
