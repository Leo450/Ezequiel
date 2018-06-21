			<!-- footer -->
			<footer class="l-footer" role="contentinfo">

				<div class="l-footer__top">

					<div class="container">

						<div class="row align-items-center">

							<div class="col-auto">
								<!-- logo -->
								<a class="l-logo" href="<?php echo home_url(); ?>">
									Le petit théâtre<br>du bout du monde
									<span>Opus II</span>
								</a>
								<!-- /logo -->
							</div>

							<div class="col">
								<div class="contact">

									<a href="/presse-et-contact/" class="button button-yellow button-narrow">Contact & presse</a>

									<div class="follow">
										Suivez-nous
										<?php get_template_part('socials'); ?>
									</div>

								</div>
							</div>

							<div class="col col-auto">
								<div class="links">
									<a href="/plan-du-site/">Plan du site</a>
									<a href="/mentions-legales/">Mentions légales</a>
								</div>
							</div>

						</div>

					</div>

				</div>

				<div class="l-footer__bottom">

					<!-- copyright -->
					<p class="copyright">
						&copy; <?php echo date('Y'); ?> - <?php bloginfo('name'); ?>
					</p>
					<!-- /copyright -->

				</div>

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
