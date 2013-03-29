<?php
/*
Plugin Name: StuBru Facebook
Plugin URI: http://mantebridts.be
Description: Toont de facebook-likebox
Author: Mante Bridts
Version: 1
Author URI: http://mantebridts.be/
*/
 
class Facebook_Widget extends WP_Widget
{
  function Facebook_Widget()
  {
    $widget_ops = array('classname' => 'Facebook_Widget', 'description' => 'Toont een likebox ivm een STF-pagina op facebook');
    $this->WP_Widget('Facebook_Widget', 'Facebook Stubru', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args((array) $instance, array( 'fbpage' => '' ));
    $fbpage = $instance['fbpage'];
?>
  <p><label for="<?php echo $this->get_field_id('fbpage'); ?>">Facebook pagina: <input class="widefat" id="<?php echo $this->get_field_id('fbpage'); ?>" name="<?php echo $this->get_field_name('fbpage'); ?>" type="text" value="<?php echo attribute_escape($fbpage); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['fbpage'] = $new_instance['fbpage'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $fbpage = empty($instance['fbpage']) ? '' : apply_filters('widget_title', $instance['fbpage']);
 
    // Do Your Widgety Stuff Here...
   ?>
   <div id="facebook" class="likeboxwrap border_grey box">
  <iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo rawurlencode($fbpage);?>&amp;width=240&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=320" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:320px;" allowTransparency="true"></iframe>
</div>
<!-- Close #facebook -->
   <?php
 	
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("Facebook_Widget");') );
 
?>