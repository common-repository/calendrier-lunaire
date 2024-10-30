<?php
/**
 * Moon Calendar Widget
 *
 * Display the moon calendar of the day (moon phases, moon rise/set times, ...)
 *
 * @package   MoonCalendarWidget
 * @author    Publigo <contact@publigo.fr>
 * @license   Copyright 2013 Calendrier-Lunaire.fr
 * @link      http://www.publigo.fr/
 * @copyright Copyright 2013 Calendrier-Lunaire.fr
 *
 * @wordpress-plugin
 * Plugin Name: Moon Calendar Widget
 * Plugin URI:  
 * Description: Display the moon calendar of the day (moon phases, moon rise/set times, ...)
 * Version:     1.0.3
 * Author:      Calendrier-Lunaire.fr
 * Author URI:  http://www.calendrier-lunaire.fr/
 * Text Domain: moon-calendar-locale
 * License:     Copyright 2013 Calendrier-Lunaire.fr
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

class Moon_Calendar_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'moon_calendar_widget', // Base ID
			'Moon Calendar Widget', // Name
			array(
                'description' => __('Display the moon calendar of the day (moon phases, moon rise/set times, ...)', 'moon-calendar-locale')
            )
		);
        
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
	}
    
	/**
	 * Register and enqueue admin-specific JavaScript.
	 */
    public function admin_enqueue_scripts($hook_suffix) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('moon-calendar-widget-js', plugins_url('js/admin.js', __FILE__ ), array('wp-color-picker'), false, true);
    }
    
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
        $lang = esc_attr($instance['lang']);
        $format = esc_attr($instance['format']);
        $font_color = esc_attr($instance['font_color']);
        $background_color = esc_attr($instance['background_color']);
        $border_color = esc_attr($instance['border_color']);
        
		echo $args['before_widget'];
        
        echo '<a href="http://www.calendrier-lunaire.fr" title="'. __('Calendrier Lunaire, jardiner avec la lune : phases, éphémérides, éclipses...', 'moon-calendar-locale') .'" target="_blank">';
        echo '<img src="http://www.calendrier-lunaire.fr/api/moon.php?font='. $font_color .'&bg='. $background_color .'&border='. $border_color .'&format='. $format .'&lang='. $lang .'" alt="'. __('Calendrier Lunaire, jardiner avec la lune : phases, éphémérides, éclipses...', 'moon-calendar-locale') .'" />';
        echo '</a>';
        
        echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
        
        if (isset($instance['lang']))
            $lang = esc_attr($instance['lang']);
        else
            $lang = 'fr';
        
        if (isset($instance['format']))
            $format = esc_attr($instance['format']);
        else
            $format = 2;
        
        if (isset($instance['font_color']))
            $font_color = '#'.esc_attr($instance['font_color']);
        else
            $font_color = '#FFFFFF';
        
        if (isset($instance['background_color']))
            $background_color = '#'.esc_attr($instance['background_color']);
        else
            $background_color = '#24405D';
        
        if (isset($instance['border_color']))
            $border_color = '#'.esc_attr($instance['border_color']);
        else
            $border_color = '#000000';
		?>
        <p>
            <label for="<?php echo $this->get_field_id("lang"); ?>"><?php _e('Langue d\'affichage :', 'moon-calendar-locale'); ?> </label><br />
            <select name="<?php echo $this->get_field_name("lang"); ?>" id="<?php echo $this->get_field_id("lang"); ?>">
                <option value="fr" <?php if (isset($lang) && $lang == 'fr') echo 'selected="selected"'; ?>><?php _e('Français', 'moon-calendar-locale'); ?></option>
                <option value="en" <?php if (isset($lang) && $lang == 'en') echo 'selected="selected"'; ?>><?php _e('English', 'moon-calendar-locale'); ?></option>
                <option value="de" <?php if (isset($lang) && $lang == 'de') echo 'selected="selected"'; ?>><?php _e('Deutsch', 'moon-calendar-locale'); ?></option>
                <option value="es" <?php if (isset($lang) && $lang == 'es') echo 'selected="selected"'; ?>><?php _e('Español', 'moon-calendar-locale'); ?></option>
                <option value="ca" <?php if (isset($lang) && $lang == 'ca') echo 'selected="selected"'; ?>><?php _e('Català', 'moon-calendar-locale'); ?></option>
                <option value="ho" <?php if (isset($lang) && $lang == 'ho') echo 'selected="selected"'; ?>><?php _e('Nederlands', 'moon-calendar-locale'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("format"); ?>"><?php _e('Format :', 'moon-calendar-locale'); ?> </label><br />
            <select name="<?php echo $this->get_field_name("format"); ?>" id="<?php echo $this->get_field_id("format"); ?>">
                <option value="2" <?php if (isset($format) && $format == 2) echo 'selected="selected"'; ?>><?php _e('Large (215 x 360 px)', 'moon-calendar-locale'); ?></option>
                <option value="1" <?php if (isset($format) && $format == 1) echo 'selected="selected"'; ?>><?php _e('Réduit (170 x 300 px)', 'moon-calendar-locale'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("font_color"); ?>"><?php _e('Couleur du texte :', 'moon-calendar-locale'); ?> </label>
            <input name="<?php echo $this->get_field_name("font_color"); ?>" id="<?php echo $this->get_field_id("font_color"); ?>" class="moon_calendar_color_picker" value="<?php echo $font_color; ?>" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("background_color"); ?>"><?php _e('Couleur de fond :', 'moon-calendar-locale'); ?> </label>
            <input name="<?php echo $this->get_field_name("background_color"); ?>" id="<?php echo $this->get_field_id("background_color"); ?>" class="moon_calendar_color_picker" value="<?php echo $background_color; ?>" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("border_color"); ?>"><?php _e('Couleur de la bordure :', 'moon-calendar-locale'); ?> </label>
            <input name="<?php echo $this->get_field_name("border_color"); ?>" id="<?php echo $this->get_field_id("border_color"); ?>" class="moon_calendar_color_picker" value="<?php echo $border_color; ?>" type="text" />
        </p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        
        $hexcolor_pattern = "/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})/i";
        $expected_langs = array('fr', 'en', 'de', 'es', 'ca', 'ho');
		
		if (!empty($new_instance['lang']) && in_array($new_instance['lang'], $expected_langs))		
            $instance['lang'] = esc_attr($new_instance['lang']);
        
        if (!empty($new_instance['format']) && is_numeric($new_instance['format']))
            $instance['format'] = esc_attr($new_instance['format']);
        
        if (!empty($new_instance['font_color'])) {
            $font_color = str_replace('#', '', $new_instance['font_color']);
            if (preg_match($hexcolor_pattern, $font_color))
                $instance['font_color'] = $font_color;
        }
        
        if (!empty($new_instance['background_color'])) {
            $background_color = str_replace('#', '', $new_instance['background_color']);
            if (preg_match($hexcolor_pattern, $background_color))
                $instance['background_color'] = $background_color;
        }
        
        if (!empty($new_instance['border_color'])) {
            $border_color = str_replace('#', '', $new_instance['border_color']);
            if (preg_match($hexcolor_pattern, $border_color))
                $instance['border_color'] = $border_color;
        }

		return $instance;
	}
    
}

// Register widget
function Moon_Calendar_Widget_init() {
    register_widget('Moon_Calendar_Widget');
}
add_action('widgets_init', 'Moon_Calendar_Widget_init');

// Load the widget text domain for translation
$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain('moon-calendar-locale', null, $plugin_dir);
