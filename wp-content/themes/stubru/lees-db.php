<?
/**
 *
 * @package WordPress
 * @subpackage stubru
 * Template Name: LeesDeFbDb
 */
 
 include_once('facebook-db.php');
 $users = haalUserArrays();
get_header();
get_sidebar();
?>

<div id="content" class="">
  <table class="database_table">
    <thead>
      <tr>
        <td>Profiel</td>
        <td>Naam</td>
        <td>e-mail</td>
      </tr>
    </thead>
    <tbody>
      <?
foreach ($users as $u){
	echo '<tr><td><a href="' . $u['link'] . '">' . $u['name'] . '</a></td><td>' . $u['first_name'] . ' ' . $u['last_name'] . '</td><td>' . $u['email'] . '</td></tr>';
}
?>
    </tbody>
    <tfoot>
      <tr>
        <td>Profiel</td>
        <td>Naam</td>
        <td>email</td>
      </tr>
    </tfoot>
  </table>
</div>
<!-- Close #content -->
<div class="clearfix"></div>
</div>
<!-- Close #content_wrapper -->
<?php get_footer(); ?>
