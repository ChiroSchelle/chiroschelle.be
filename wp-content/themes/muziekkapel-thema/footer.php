			</div>	
		</div>
	</div>
	</div>
		<!-- <div class="push"></div> -->
		<div id="footer">
			<div class="footer-wrapper">
				<ul>
					<?php dynamic_sidebar( 'bottom-left' ); ?>
					<li class="copyright"><?php echo copyright(); ?></li>
				</ul>
				<ul>
					<?php dynamic_sidebar( 'bottom-middle' ); ?>
				</ul>
				<ul>
					<?php dynamic_sidebar( 'bottom-right' ); ?>
				</ul>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
