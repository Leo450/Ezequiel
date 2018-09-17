<?php

/* Template Name: Blog Template */

global $wp;
$current_url = home_url($wp->request);
$clean_url = substr($current_url, 0, strpos($current_url , '/page'));

$filter_post_type  = "";
$allowed_post_type = ["post", "log"];
if(isset($_GET['filter']) && in_array($_GET['filter'], $allowed_post_type)){
	$filter_post_type = $_GET['filter'];
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$blog_posts_query = new WP_Query([
	'post_type'=> (empty($filter_post_type))? $allowed_post_type : $filter_post_type,
	'order'    => 'DESC',
	'posts_per_page' => 7,
	'paged' => $paged
]);

?>

<?php get_header(); ?>

<main role="main">

	<!-- section -->
	<section class="section section-blog">

		<div class="container">

			<h1 class="page-title">Le blog du petit théâtre du bout du monde</h1>

			<strong>Découvrez l'avancement du Petit théâtre du bout du monde grâce à notre carnet de bord et suivez chacunes des étapes du projet.<br>Retrouvez également nos articles d'actualité sur le thème de l'art contemporain, du théâtre, de la marionnette ou encore du jeu vidéo.</strong>

			<div class="filters">

				<span>Filtres:</span>
				<a href="<?php echo $clean_url; ?>?filter=null" class="button button-narrow button-rounded<?php if(empty($filter_post_type)){ echo " active"; } ?>">Tout voir</a>
				<a href="<?php echo $clean_url; ?>?filter=log" class="button button-narrow button-rounded<?php if($filter_post_type == "log"){ echo " active"; } ?>">Carnet de bord du projet</a>
				<a href="<?php echo $clean_url; ?>?filter=post" class="button button-narrow button-rounded<?php if($filter_post_type == "post"){ echo " active"; } ?>">Actualités</a>

			</div>

			<?php if($blog_posts_query->have_posts()): ?>

				<div class="thumb thumb-full thumb-alone">
					<div class="row align-items-center">

						<div class="col-md-4">
							<div class="thumbnail">
								<div style="background-image:url('<?php echo get_the_post_thumbnail_url($blog_posts_query->post->ID); ?>');"></div>
							</div>
						</div>
						<div class="col-md-8">
							<h4 class="title"><?php echo $blog_posts_query->post->post_title; ?></h4>
							<span class="date">Publié le <?php echo get_the_time("j F Y", $blog_posts_query->post->ID); ?></span>
                            <p class="desc"><?php echo $blog_posts_query->post->post_excerpt; ?></p>
							<a href="<?php echo get_permalink($blog_posts_query->post->ID); ?>" class="button">Lire la suite</a>
						</div>

					</div>
				</div>

				<?php $blog_posts_query->the_post(); ?>

				<div class="row">

					<?php while($blog_posts_query->have_posts()): $blog_posts_query->the_post(); ?>

						<div class="col-md-4">

							<div class="row<?php if(($blog_posts_query->current_post) % 3 == 2){ echo ' justify-content-center'; }elseif(($blog_posts_query->current_post) % 3 == 0){ echo ' justify-content-end'; } ?>">

								<div class="col-md-10">

									<div class="thumb thumb-full">
										<div class="thumbnail">
											<div style="background-image:url('<?php echo get_the_post_thumbnail_url($blog_posts_query->post->ID); ?>');"></div>
										</div>
										<h4 class="title"><?php echo $blog_posts_query->post->post_title; ?></h4>
										<span class="date">Publié le <?php echo get_the_time("j F Y", $blog_posts_query->post->ID); ?></span>
										<p class="desc"><?php echo $blog_posts_query->post->post_excerpt; ?></p>
										<a href="<?php echo get_permalink($blog_posts_query->post->ID); ?>" class="button">Lire la suite</a>
										<div class="clear"></div>
									</div>

								</div>

							</div>

						</div>

						<div class="w-100 d-md-none"></div>

						<?php if(($blog_posts_query->current_post) % 3 == 0): ?>
							<div class="w-100 d-none d-md-block"></div>
						<?php endif; ?>

					<?php endwhile; ?>

				</div>

				<?php ez_pagination($blog_posts_query, $paged); ?>

				<div class="w-100 d-md-none"></div>

			<?php endif; ?>

		</div>

	</section>
	<!-- /section -->

</main>

<?php get_footer(); ?>
