	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">
<blockquote>
<table border="0px">
<tr>
<td>
<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>
</td>
</tr>
</table>
</blockquote>
<center><table>
<tr>
	<td><div class="footer_text"><center><p>&copy; Aspiranten <a href="http://www.chiroschelle.be" target="_blank">Chiro Schelle</a> 2011
    </p></center>
</div></td></tr>
</table></center>
		</div><!-- #colophon -->
	</div>
	<p>
  <!-- #footer -->
	  
  </div><!-- #wrapper -->
	  
  <?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>