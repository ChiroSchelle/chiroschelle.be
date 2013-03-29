<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage stubru
 */
?>

<div id="footer_wrapper">
  <div id="footershadow"> </div>
  <div id="footer">
    <div id="footer_sidebar"> <a href="http://www.chiroschelle.be"><img src="<?php bloginfo('template_directory'); ?>/img/logo_chiroschelle.png" /></a> <a href="http://www.schelle.be"><img src="<?php bloginfo('template_directory'); ?>/img/logo_schelle.png" /></a> </div>
    <!-- Close #footer_sidebar -->
    <div id="footer_content">
    <div class="slideshow"> <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor8.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor2.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor3.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor4.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor5.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor6.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor7.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor1.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor9.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor10.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor11.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor12.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor13.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor14.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor15.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor16.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor17.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor18.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor19.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor20.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor21.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor22.jpg" width="640" height="230"/>     
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor23.jpg" width="640" height="230"/>
	<img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor24.jpg" width="640" height="230"/>
    
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor2.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor2.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor4.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor4.jpg" width="640" height="230"/>
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor8.jpg" width="640" height="230"/> 
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor8.jpg" width="640" height="230"/> 
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor9.jpg" width="640" height="230"/> 
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor9.jpg" width="640" height="230"/> 
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor12.jpg" width="640" height="230"/> 
    <img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor12.jpg" width="640" height="230"/>
	<img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor24.jpg" width="640" height="230"/>
	<img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor24.jpg" width="640" height="230"/>
	<img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor24.jpg" width="640" height="230"/>
	<img src="<?php bloginfo('template_directory'); ?>/img/sponsors/sponsor24.jpg" width="640" height="230"/>	</div>

</div>    <!-- Close #footer_content -->
    <div class="clearfix"></div>
  </div>
  <!-- Close #footer -->
</div>
<!-- Close #footer_wrapper -->
<script>
	$(".arrow").click(function () {
		if( $(".sub-menu").is(":visible") ) {
			console.log('zichtbaar');
  		$("#menu-hoofdmenu li a:first").removeClass("open").addClass("closed");
		}
		else {
						console.log('onzichtbaar');
		 $("#menu-hoofdmenu li a:first").addClass("open").removeClass("closed");
		};
     $(".sub-menu").slideToggle("slow");
    });
  
	$(document).ready(function() {
  		$(".white_banner").hide();
		//$("#menu-hoofdmenu li a:first").attr("onclick","return false;");
		initialize();		
	});
		
	$(".picture").hover(
  		function () {
			$("#"+this.id+" .white_banner").stop(true, true);
    		$("#"+this.id+" .white_banner").fadeIn("slow");
  		}, 
  		function () {
    		$("#"+this.id+" .white_banner").stop(true, true);
			$("#"+this.id+" .white_banner").fadeOut();
  		}
	);
</script>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body></html>