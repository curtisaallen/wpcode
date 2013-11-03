<?php
/*
Plugin Name: Recent Post Widget - AW
Plugin URI: http://www.curtisaallen.com/
Description: A simple recent post widget
Version: 1.0
Author: CAllen
Author URI: http://www.curtisaallen.com/
License: GPL2
*/


class aw_recentposts_plugin extends WP_Widget {
  // constructor
  function aw_recentposts_plugin() {
	  $widget_ops = array('classname' => 'aw-recentposts-wdg', 'description' => 'Recent Post Widget');
	  $control_ops = array('width' => 300, 'height' => 300);
	  $this->WP_Widget('aw_recentposts_plugin', 'Recent Posts Widget', $widget_ops, $control_ops );
  }

  // widget form creation
  function form($instance) {
 //Defaults
      $instance = wp_parse_args( (array) $instance, array('title'=>'', 'number_text'=>'5',) );

      $title = htmlspecialchars($instance['title']);
	  $number_text = htmlspecialchars($instance['number_text']);

      # Output the options
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' </label><br /><input style="width: 226px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
      # Number of post Text
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('number_text') . '">' . __('Number of Post:') . ' </label><input style="width: 226px;" id="' . $this->get_field_id('number_text') . '" name="' . $this->get_field_name('number_text') . '" type="text" value="' .  $number_text . '" /></p>';        

	  
  }
  // widget update
  function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title'] = strip_tags(stripslashes($new_instance['title']));
      $instance['number_text'] = strip_tags(stripslashes($new_instance['number_text']));
      return $instance;	  
  }
  // widget display
  function widget($args, $instance) {


    extract($args);
      $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
      $number_text = empty($instance['number_text']) ? '5' : $instance['number_text'];

      # Before the widget
      echo $before_widget;

      # The title
      if ( $title )
      echo $before_title . $title . $after_title;

      # The Recent Posts Code

?>
    <ul>
    <?php $the_query = new WP_Query('showposts=' . $number_text); ?>
    <?php while($the_query->have_posts()) :  $the_query->the_post(); ?>
    <li> <?php  if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); }  ?></li>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <li> <?php the_excerpt(); ?></li>
    <?php endwhile; ?>
    </ul>
<?php 
      # After the widget
      echo $after_widget;

	  
  }	
}

  // register widget
  function AwrecentpostsInit() {
	  register_widget('aw_recentposts_plugin');
  }
add_action('widgets_init', 'AwrecentpostsInit');
?>