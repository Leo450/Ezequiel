<?php

/* Template Name: Puppets Template */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$puppets_posts_query = new WP_Query([
	'post_type'=> 'puppet',
	'order'    => 'ASC',
	'posts_per_page' => 12,
	'paged' => $paged
]);

?>

<?php get_header(); ?>

<main role="main">

	<!-- section -->
	<section class="section section-puppets">

		<div class="container">

			<h1 class="page-title">Les marionnettes</h1>

			<?php if($puppets_posts_query->have_posts()): ?>

				<div class="row">

					<?php while($puppets_posts_query->have_posts()): $puppets_posts_query->the_post(); ?>

						<div class="col-md-3">

							<div class="thumb">
								<div class="thumbnail thumbnail-square">
									<div style="background-image:url('<?php echo get_the_post_thumbnail_url($puppets_posts_query->post->ID); ?>');"></div>
								</div>
								<h4 class="title"><?php echo $puppets_posts_query->post->post_title; ?></h4>
								<a href="<?php echo get_permalink($puppets_posts_query->post->ID); ?>" class="button">Voir</a>
								<div class="clear"></div>
							</div>

						</div>

						<div class="w-100 d-md-none"></div>

						<?php if(($puppets_posts_query->current_post + 1) % 4 == 0): ?>
							<div class="w-100 d-none d-md-block"></div>
						<?php endif; ?>

					<?php endwhile; ?>

				</div>

				<?php ez_pagination($puppets_posts_query, $paged); ?>

			<?php endif; ?>

		</div>

	</section>
	<!-- /section -->

</main>

<?php get_footer(); ?>
