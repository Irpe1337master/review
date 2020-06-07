<?php

/**
 * HTML for displaying reviews
 *
 * @link       iirohongisto.com
 * @since      1.0.0
 *
 * @package    Reviews
 * @subpackage Reviews/public/partials
 */

?>
<h4>Reviews by other people!</h4>
<?php
if ( $reviews ) {
    foreach ( $reviews as $review ) {
      echo '<div class="border-bottom">';
        echo '<h5>' . esc_html( $review->post_title ) . '</h5>';
        echo '<p>' . esc_html( $review->post_content ) . '</p>';

        $review_score = wp_get_post_terms($review->ID, 'review_score', array( 'fields' => 'names' ));

        if ( $display_score && $review_score ) {
          echo '<p><b>Score: ' . esc_html( $review_score[0] ) . '</b></p>';
        }

      echo '</div>';
    }
} else {
    echo '<p>'. __('No reviews found!', 'aucor') .'</p>';
}
