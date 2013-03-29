<?php
/**
* @package WordPress
* @subpackage Chiro_Schelle
*/
// TOON ALLEEN ERRORS, GEEN WARNINGS OF NOTICES:
error_reporting(E_ERROR | E_ALL & ~E_NOTICE);
//error_reporting(E_ERROR | E_ALL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php wp_title('&laquo;', true, 'right'); ?>
<?php bloginfo('name'); ?>
</title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--<link rel="stylesheet" href="<?php echo get_bloginfo('template_url').'/css/handheld.css';?>" media="handheld,only screen and (max-device-width:480px)"/>-->
<link rel="stylesheet" href="<?php echo get_bloginfo('template_url').'/css/print.css'; ?>" type="text/css" media="print" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<? echo get_bloginfo('template_url').'/images/favicon.ico'; ?>" />
<link rel="icon" type="image/png" href="<? echo get_bloginfo('template_url').'/images/favicon.png'; ?>" />
<!-- Poging om jQuery porbleem op te lossen (Mante, 29 juni 2010)-->
<script type='text/javascript' src='http://www.chiroschelle.be/wp-includes/js/jquery/jquery.js?ver=1.4.2'></script>
<?php
//automatische feed discovery --Ben 4 Mei 2010
if (function_exists('automatic_feed_links')) {
automatic_feed_links();
}
?>
<?php /*?><style type="text/css" media="screen">
<?php //Checks to see whether it needs a sidebar or not
if ( empty($withcomments) && !is_single() ) {
?> #page {
background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbg-<?php bloginfo('text_direction'); ?>.jpg") repeat-y top;
border: none;
}
<?php
}
else {
// No sidebar ?> #page {
background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgwide.jpg") repeat-y top;
border: none;
}
<?php
}
?>
</style><?php */?>
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); 
?>
<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/show_hide_form.js"></script>
<!--
<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/niceforms.js"></script>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/niceforms-default.css" type="text/css" media="screen" />
-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="toptop">
  <p />
  <a class="toplink" href="<?php bloginfo("url") ?>/contact">Contact</a> |
  <?php
if ( $user_ID ) {  
?>
  <a class="toplink" href="<?php echo wp_logout_url( $redirect ); ?>  ">Log uit</a> | <a class="toplink" href="<?php bloginfo("url") ?>/wp-admin">Beheer</a> |
  <?php 
}
else {
?>
  <a class="toplink" href="<?php bloginfo("url") ?>/wp-login.php?action=login">Log in</a> | <a class="toplink" href="<?php bloginfo("url") ?>/wp-login.php?action=register">Registreer</a> |
  <?php
}
?>
  <a class="toplink" href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo("template_directory") ?>/images/rss.png" alt="rss" /></a>
  <a class="toplink" href="http://www.facebook.com/chiroschelle"><img src="<?php bloginfo("template_directory") ?>/images/fb.png" alt="fb" /></a> 
  <a class="toplink" href="http://twitter.com/chiroschelle"><img src="<?php bloginfo("template_directory") ?>/images/twit.png" alt="twit" /></a> 
  </div>
<!--toptop-->
<div id="menucontainer" class="noprint">
  <?php
// MOET DIT NIE IN FUNCTIONS.PHP? --Ben
function menufoto() {
$menufoto = "menu" . rand(1,20);
echo $menufoto;
}
?>

  <a href="<?php bloginfo("url") ?>" id="homelink"></a>
  <div id="verjaardag"></div>
  <div id="<?php menufoto()?>" class="menuimage"></div>
  <div id="menu">
    <?php wp_nav_menu( array( 'menu' => 'hoofdmenu' )); ?>
  </div>
  <!--menu-->
</div>
<!--menucontainer-->
<!--/body staat in footer.php-->
