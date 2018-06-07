<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<div class="container">

				<!-- article -->
				<article id="post-404">

					<h1 class="page-not-found"><?php _e( 'Page not found', 'html5blank' ); ?></h1>
					<a class="button" href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>

				</article>
				<!-- /article -->

			</div>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
