<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       iirohongisto.com
 * @since      1.0.0
 *
 * @package    Reviews
 * @subpackage Reviews/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Reviews
 * @subpackage Reviews/public
 * @author     Iiro Hongisto <iiro.roar@gmail.com>
 */
class Reviews_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/reviews-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/reviews-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register shortcodes
	 *
	 * @since    1.0.0
	 */
	public function aucor_register_shortcodes() {
		add_shortcode('add-review', array( $this, 'aucor_review_form' ) );
		add_shortcode('display-post-reviews', array( $this, 'aucor_display_post_reviews' ) );
	}

	/**
	 * Handle review form actions. Display the form and saves the review.
	 * Shortcode
	 *
	 * @since    1.0.0
	 */
	public function aucor_review_form() {

		$save_review = false;
		$save_review = $this->aucor_validate_form_fields();
		$review_scores = [];

		$plugin_settings = get_option( 'aucor_reviews_settings' );
		$display_score = ( isset( $plugin_settings['aucor_display_score_field'] ) && $plugin_settings['aucor_display_score_field'] == 1) ? true : false;

		// Available only on posts
		if ( is_single() == false ) {
			$error_message = 'Display review form with a post. :)';
			include_once 'partials/reviews-shortcode-error.php';
			return;
		}

		// Check conditional logic in settings
		if ( $this->aucor_conditional_logic() == false ) {
			return;
		}

		// Save review form input or display form
		if ($save_review == true) {

			$post_id = $this->aucor_save_review();

			if ( $post_id ) {
				include_once 'partials/reviews-shortcode-review-added.php';
			} else {
				include_once 'partials/reviews-shortcode-add-review.php';
			}

		} else {

			$review_scores = get_terms( array(
			    'taxonomy' => 'review_score',
			    'hide_empty' => false,
			) );

			include_once 'partials/reviews-shortcode-add-review.php';
		}

	}

	/**
	 * Display posts reviews.
	 * Shortcode
	 *
	 * @since    1.0.0
	 */
	public function aucor_display_post_reviews() {

		// Available only on posts
		if ( is_single() == false ) {
			$error_message = 'Display reviews with a post. :)';
			include_once 'partials/reviews-shortcode-error.php';
			return;
		}

		// Check conditional logic in settings
		if ( $this->aucor_conditional_logic() == false ) {
			return;
		}

		$plugin_settings = get_option( 'aucor_reviews_settings' );
		$display_score = ( isset( $plugin_settings['aucor_display_score_field'] ) && $plugin_settings['aucor_display_score_field'] == 1) ? true : false;

		// Fetch posts reviews. The posts ID is saved into CPT reviews metadata
		$args = array(
		    'post_type'  => 'reviews',
		    'meta_query' => array(
		        array(
		            'key'   => 'aucor_reviewed_post',
		            'value' => get_the_ID(),
		        )
		    )
		);
		$reviews = get_posts( $args );

		// echo '<pre>'; var_dump($reviews); echo '</pre>';

		include_once 'partials/reviews-shortcode-display-reviews.php';

		wp_reset_postdata();

	}

	/**
	 * Conditional logic to display or hide elements
	 *
	 * @since    1.0.0
	 */
	public function aucor_conditional_logic() {

		$display = true;
		$post_categories = get_the_category();
		$plugin_settings = get_option( 'aucor_reviews_settings' );

		// Display elements based on post category. Display logic is defined in plugin settings
		if ( isset( $plugin_settings['aucor_category_filter_field'] ) ) {
			foreach ( $post_categories as $post_category ) {
				if (  in_array( $post_category->term_id, $plugin_settings['aucor_category_filter_field'] )  ) {
					$display = true;
					break;
				} else {
					$display = false;
				}
			}
		}

		return $display;

	}

	/**
	 * Check that required fields are set
	 *
	 * @since    1.0.0
	 */
	private function aucor_validate_form_fields() {

		$valid = true;

		if ( !isset( $_POST['review_title'] ) || empty( $_POST['review_title'] ) ) {
			$valid = false;
		}

		if ( !isset( $_POST['review_content'] )  || empty( $_POST['review_content'] )) {
			$valid = false;
		}

		if ( !isset( $_POST['review_score'] )  || empty( $_POST['review_score'] )) {
			$valid = false;
		}

		return $valid;

	}

	/**
	 * Save review
	 *
	 * @since    1.0.0
	 */
	public function aucor_save_review() {

		// TODO ADD NONCE VERIFICATION
		$post_id = 0;

		$post_information = array(
	    'post_title' => wp_strip_all_tags( $_POST['review_title'] ),
	    'post_content' => wp_strip_all_tags( $_POST['review_content'] ),
	    'post_type' => 'reviews',
	    'post_status' => 'publish'
		);

		$post_id = wp_insert_post( $post_information );

		if ( $post_id ) {
			// Add score category
			wp_set_post_terms( $post_id, array( intval( $_POST['review_score'] ) ), 'review_score' );

			// Link review to post using post meta
			add_post_meta( $post_id, 'aucor_reviewed_post', get_the_ID() );
		}

		return $post_id;

	}


}
