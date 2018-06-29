<?php

/* Template Name: Contact Template */

?>

<?php get_header(); ?>

<main role="main">

	<!-- section -->
	<section class="section section-contact-page">

		<div class="container">

			<h1 class="page-title">Presse contact</h1>

			<article>

				<div class="row">

					<div class="col-md-5"></div>
					<div class="col-md-7">

						<h1>Téléchargez le dossier de présentation du projet</h1>

						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto blanditiis consequuntur dolorum eius enim in ratione sed sint ullam. Amet at deleniti id illum nulla officiis praesentium quis quod rerum.</p>

						<a href="<?php echo wp_get_attachment_url(174) ?>" target="_blank" class="button button-filled button-yellow">Télécharger</a>

					</div>

				</div>

			</article>

		</div>

	</section>
	<!-- /section -->

	<section class="section section-yellow">

		<div class="section-title">
			<h1 class="title">Contactez l'équipe</h1>
			<h3 class="sub-title">Laissez nous un message</h3>
		</div>

		<div class="container">

			<?php echo do_shortcode("[contact-form-7 id=\"23\" title=\"Formulaire de contact 1\"]"); ?>

		</div>

	</section>

</main>

<?php get_footer(); ?>
