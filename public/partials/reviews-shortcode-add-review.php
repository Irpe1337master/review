<?php

/**
 * HTML for adding review. Used by shortcode
 *
 * @link       iirohongisto.com
 * @since      1.0.0
 *
 * @package    Reviews
 * @subpackage Reviews/public/partials
 */
?>

<h4><?php _e('Hello friend! Write your review about this review.', 'aucor') ?></h4>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form id="form-add-review" method="POST">
  <div class="form-group">
    <label for="input-review-title"><?php _e('Review Title', 'aucor') ?></label>
    <input
      type="text"
      class="form-control"
      name="review_title"
      id="input-review-title"
      value="<?php if ( isset( $_POST['review_title'] ) ) echo esc_html( $_POST['review_title'] ); ?>"
      placeholder="<?php _e('Review Title', 'framework') ?>"
      required>
  </div>
  <div class="form-group">
    <label for="textarea-review-content"><?php _e('Review', 'aucor') ?></label>
    <textarea
      class="form-control"
      name="review_content"
      id="textarea-review-content"
      rows="5"
      required><?php if ( isset( $_POST['review_content'] ) ) echo esc_html( $_POST['review_content'] ); ?></textarea>
  </div>
  <?php if ( $display_score ): ?>
    <div class="form-group">
      <label for="select-review-score"><?php _e('Score', 'aucor') ?></label>
      <select class="form-control" name="review_score" id="select-review-score">
        <?php
          foreach ( $review_scores as $review_score ) {
            echo '<option value="'. esc_html( $review_score->term_id ) .'">'. esc_html( $review_score->name ) .'</option>';
          }
        ?>
      </select>
    </div>
  <?php endif; ?>
  <button type="submit" class="btn btn-primary"><?php _e('Add Review', 'aucor') ?></button>
</form>
