<?php
/**
 * Settings for admin
 *
 * Defines the available settings for plugin
 *
 * @package    Reviews
 * @subpackage Reviews/settings
 * @author     Iiro Hongisto <iiro.roar@gmail.com>
 */
class Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

  /**
	 * The plugin options
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options    The options
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

  /**
	 * Admin settings page
	 *
	 * @since    1.0.0
	 */
	 public function aucor_add_options_page() {
		 add_menu_page( __( 'Aucor reviews settings' ), __( 'Aucor reviews settings' ), 'manage_options', 'aucor-reviews-settings', array( $this, 'aucor_display_options_page' ));
	 }

	 /**
	  * Admin settings page HTML
	  *
	  * @since    1.0.0
	  */
	 public function aucor_display_options_page() {
		 include_once 'partials/reviews-admin-display.php';
	 }

  /**
  * Register all related settings of this plugin
  *
  * @since  1.0.0
  */
 public function aucor_register_settings() {

   add_settings_section(
     'aucor_reviews_settings_section',
     __( 'Reviews Settings', 'aucor' ),
     '', // Callback
     'aucor-reviews-settings' // Settings page
   );

   add_settings_field(
     'aucor_display_score_field', // Slug for this
     __( 'Display score', 'aucor' ),
     array( $this, 'aucor_display_score_callback' ), // Callback
     'aucor-reviews-settings', // Settings page
     'aucor_reviews_settings_section', // Section belongs to
   );

   add_settings_field(
     'aucor_category_filter_field', // Slug for this
     __( 'Display by category', 'aucor' ),
     array( $this, 'aucor_display_category_filter_callback' ), // Callback
     'aucor-reviews-settings', // Settings page
     'aucor_reviews_settings_section', // Section belongs to
   );

   register_setting( 'aucor_reviews_settings', 'aucor_reviews_settings', array( $this, 'aucor_sanitize_score' ) );

 }


 /**
 * Get the settings option array and print one of its values
 */
public function aucor_display_score_callback() {
  $this->options = get_option( 'aucor_reviews_settings' );

//var_dump($this->options);
  echo '<input id="aucor-display-score" name="aucor_reviews_settings[aucor_display_score_field]" type="checkbox" value="1"'.
    ( isset( $this->options['aucor_display_score_field'] )  ? checked( $this->options['aucor_display_score_field'], 1, false ) : '' )
  .' />';
}

/**
* Get the settings option array and print one of its values
*/
public function aucor_display_category_filter_callback() {

 $this->options = get_option( 'aucor_reviews_settings' );
 $categories = get_categories();

 echo '<select id="aucor-category-filter-field" name="aucor_reviews_settings[aucor_category_filter_field][]" multiple>';

   foreach ($categories as $category) {
     if ( in_array( $category->term_id, $this->options['aucor_category_filter_field'] ) ) {
       echo '<option value="'. $category->term_id .'" selected>'. $category->name .'</option>';
     } else {
       echo '<option value="'. $category->term_id .'">'. $category->name .'</option>';
     }
   }

 echo '</select>';

}

/**
* Sanitize
*/
public function aucor_sanitize_score( $input ) {
  $new_input = array();

  if ( isset( $input['aucor_display_score_field'] ) ) {
    $new_input['aucor_display_score_field'] = intval( $input['aucor_display_score_field'] );
  }

  if ( isset( $input['aucor_category_filter_field'] ) ) {
    $new_input['aucor_category_filter_field'] = array_map( 'intval', $input['aucor_category_filter_field'] );
  }

  return $new_input;
}



}
