<?php
/*
Plugin Name: StuBru Twitter
Plugin URI: http://mantebridts.be
Description: Toont de twitter-feed
Author: Mante Bridts
Version: 1
Author URI: http://mantebridts.be/
*/
 
class Twitter_Widget extends WP_Widget
{
  function Twitter_Widget()
  {
    $widget_ops = array('classname' => 'Twitter_Widget', 'description' => 'Toont een twitter-feed ivm StuBru en/of STF');
    $this->WP_Widget('Twitter_Widget', 'Twitter Stubru', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args((array) $instance, array( 'query' => '' ));
    $query = $instance['query'];
?>
  <p><label for="<?php echo $this->get_field_id('query'); ?>">Twitter zoekterm: <input class="widefat" id="<?php echo $this->get_field_id('query'); ?>" name="<?php echo $this->get_field_name('query'); ?>" type="text" value="<?php echo attribute_escape($query); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['query'] = $new_instance['query'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $query = empty($instance['query']) ? '' : apply_filters('widget_title', $instance['query']);
 
    // Do Your Widgety Stuff Here...
   ?>
    <div id="twitter" class="border_grey box"><h3>Tweet mee: <a class="hashtag" href="http://twitter.com/#!/search/8090of2000">#8090of2000</a></h3>
      <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
      <script src="http://widgets.twimg.com/j/2/widget.js"></script>
      <script>
new TWTR.Widget({
  version: 2,
  type: 'search',
  search: '<?php echo $query ?>',
  interval: 200000,
  title: '',
  subject: '',
  width: 'auto',
  height: 230,
  theme: {
    shell: {
      background: '#ffffff',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#404040',
      links: '#bb2b28'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    toptweets: false,
    behavior: 'default'
  }
}).render().start();
</script>
<a href="http://twitter.com/chiroschelle" class="twitter-follow-button" data-show-count="false" data-link-color="BB2A28">Follow @chiroschelle</a>
    </div>
    <!-- Close #twitter -->
   <?php
 	
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("Twitter_Widget");') );
 
?>