<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       iirohongisto.com
 * @since      1.0.0
 *
 * @package    Reviews
 * @subpackage Reviews/admin/partials
 */
?>

<div class="wrap">
    <h1>Manage plugin</h1>
    <form method="post" action="options.php">
    <?php
    
        // This prints out all hidden setting fields
        settings_fields( 'aucor_reviews_settings' );
        do_settings_sections( 'aucor-reviews-settings' );
        submit_button();
    ?>
    </form>
</div>
<?php
