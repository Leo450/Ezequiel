<?php

/* Template Name: Blog Template */

global $wp;
$current_url = home_url($wp->request);
$clean_url = substr($current_url, 0, strpos($current_url , '/page'));

$filter_post_type  = "post";
$allowed_post_type = ["post", "log"];
if(isset($_GET['filter']) && in_array($_GET['filter'], $allowed_post_type)){
	$filter_post_type = $_GET['filter'];
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$blog_posts_query = new WP_Query([
	'post_type'=> $filter_post_type,
	'order'    => 'ASC',
	'posts_per_page' => 7,
	'paged' => $paged
]);

?>

<?php get_header(); ?>

<main role="main">

	<!-- section -->
	<section class="section section-blog">

		<div class="container">

			<div class="row">

				<div class="col-7">

					<h1 class="page-title">Le blog du petit théâtre</h1>

					<strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem blanditiis corporis debitis dignissimos dolore eum inventore laboriosam optio, pariatur possimus praesentium, ut voluptatem! Aliquam animi fuga numquam voluptates. Ipsum, reprehenderit?</strong>

				</div>
				<div class="col-5">

					<img src="http://via.placeholder.com/350x150" alt="">

				</div>

			</div>

			<div class="filters">

				<span>Filtres:</span>
				<a href="<?php echo $clean_url; ?>?filter=log" class="button button-narrow button-rounded<?php if($filter_post_type == "log"){ echo " active"; } ?>">Carnet de bord du projet</a>
				<a href="<?php echo $clean_url; ?>?filter=post" class="button button-narrow button-rounded<?php if($filter_post_type == "post"){ echo " active"; } ?>">Actualités du théâtre et de la marionette</a>

			</div>

			<?php if($blog_posts_query->have_posts()): ?>

				<div class="thumb thumb-full thumb-alone">
					<div class="row align-items-center">

						<div class="col-4">
							<img src="<?php echo get_the_post_thumbnail_url($blog_posts_query->post->ID); ?>" alt="thumbnail">
						</div>
						<div class="col-8">
							<h4 class="title"><?php echo $blog_posts_query->post->post_title; ?></h4>
							<span class="date">Publié le <?php echo get_the_time("j F Y", $blog_posts_query->post->ID); ?></span>
							<p class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aspernatur consequatur, culpa deleniti dicta dignissimos dolorum eius exercitationem libero magnam nam non odit officia optio quam reiciendis repellendus. A, unde!</p>
							<a href="<?php echo get_permalink($blog_posts_query->post->ID); ?>" class="button">Lire la suite</a>
						</div>

					</div>
				</div>

				<?php $blog_posts_query->the_post(); ?>

				<div class="row">

					<?php while($blog_posts_query->have_posts()): $blog_posts_query->the_post(); ?>

						<div class="col-4">

							<div class="row<?php if(($blog_posts_query->current_post) % 3 == 2){ echo ' justify-content-center'; }elseif(($blog_posts_query->current_post) % 3 == 0){ echo ' justify-content-end'; } ?>">

								<div class="col-10">

									<div class="thumb thumb-full">
										<img src="<?php echo get_the_post_thumbnail_url($blog_posts_query->post->ID); ?>" alt="thumbnail">
										<h4 class="title"><?php echo $blog_posts_query->post->post_title; ?></h4>
										<span class="date">Publié le <?php echo get_the_time("j F Y", $blog_posts_query->post->ID); ?></span>
										<p class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aspernatur consequatur, culpa deleniti dicta dignissimos dolorum eius exercitationem libero magnam nam non odit officia optio quam reiciendis repellendus. A, unde!</p>
										<a href="<?php echo get_permalink($blog_posts_query->post->ID); ?>" class="button">Lire la suite</a>
										<div class="clear"></div>
									</div>

								</div>

							</div>

						</div>

						<?php if(($blog_posts_query->current_post) % 3 == 0): ?>
							<div class="w-100"></div>
						<?php endif; ?>

					<?php endwhile; ?>

				</div>

				<?php ez_pagination($blog_posts_query, $paged); ?>

			<?php endif; ?>

		</div>

	</section>
	<!-- /section -->

</main>

<?php get_footer(); ?>
