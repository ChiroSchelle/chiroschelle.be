<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package gidsen-sint-jan
 */

?>

	<!-- End main-container -->
	</div>

	<footer class="site-footer" role="contentinfo">
		<div class="container cleafix">
			<div class="column">
				<h3><span class="border">Op de website</span></h3>
				<div class="footer-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>
				</div>
			</div>
			<div class="column">
				<div class="contact-wrapper">
					<h3><span class="border">Contacteer ons</span></h3>
					<address>
						<div class="adress">
							<span class="street">Koekoekstraat 100</span>
							<span class="city">2630 Aartselaar</span>
						</div>
						<span class="mail">info@gidsensintjan.be</span>
					</address>
				</div>

				<div class="social-wrapper">
					<h3><span class="border">Social media</span></h3>
						<ul class="social">
							<li><a class="facebook" href="https://www.facebook.com/gidsensintjan">Facebook</a></li>
							<li><a class="twitter" href="https://twitter.com/search?q=%23gidsensintjan&src=typd">Twitter</a></li>
							<li><a class="youtube" href="https://www.youtube.com/watch?v=nHP4uYj_0JY">Youtube</a></li>
						</ul>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/lightbox.min.js"></script>
</body>
</html>
