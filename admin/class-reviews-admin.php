<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       iirohongisto.com
 * @since      1.0.0
 *
 * @package    Reviews
 * @subpackage Reviews/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Reviews
 * @subpackage Reviews/admin
 * @author     Iiro Hongisto <iiro.roar@gmail.com>
 */
class Reviews_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Reviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Reviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/reviews-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Reviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Reviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/reviews-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Reviews CPT
	 *
	 * @since    1.0.0
	 */
	public function aucor_reviews_custom_post_type(){

		$labels = array(
			'name'               => _x( 'Reviews', 'post type general name', 'aucor' ),
			'singular_name'      => _x( 'Review', 'post type singular name', 'aucor' ),
			'add_new'            => _x( 'Add Review', 'add review', 'aucor' ),
			'add_new_item'       => __( 'Add New Review', 'aucor' ),
			'edit_item'          => __( 'Edit Review', 'aucor' ),
			'new_item'           => __( 'New Review', 'aucor' ),
			'all_items'          => __( 'All Reviews', 'aucor' ),
			'view_item'          => __( 'View Review', 'aucor' ),
			'search_items'       => __( 'Search Reviews', 'aucor' ),
			'not_found'          => __( 'No reviews found', 'aucor' ),
			'not_found_in_trash' => __( 'No reviews found in the Trash', 'aucor' ),
			'menu_name'          => 'Reviews'
		);

		$args = array(
	    'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'reviews'),
			'show_in_rest' => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	  );

		register_post_type( 'reviews', $args );
 }

 /**
  * Reviews Taxonomies
  *
  * @since    1.0.0
  */
 public function aucor_review_taxonomies() {

	// Score
	$labels = array(
    'name'              => _x( 'Score', 'taxonomy general name' ),
    'singular_name'     => _x( 'Score', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Score' ),
    'all_items'         => __( 'All Scores' ),
    'parent_item'       => __( 'Parent Score' ),
    'parent_item_colon' => __( 'Parent Score:' ),
    'edit_item'         => __( 'Edit Score' ),
    'update_item'       => __( 'Update Score' ),
    'add_new_item'      => __( 'Add New Score' ),
    'new_item_name'     => __( 'New Score' ),
    'menu_name'         => __( 'Score' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical'		=> true,
		'show_ui'         => true,
    'show_tagcloud'   => true,
		'show_in_rest' 		=> true,
  );
  register_taxonomy( 'review_score', 'reviews', $args );
}

}
