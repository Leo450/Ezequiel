<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<div class="container">

				<h1 class="page-title"><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

			</div>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
