<?php
defined('ABSPATH') || exit;

add_action('admin_notices', function() {
    if (isset($_GET['druckrechner_saved']) && $_GET['druckrechner_saved'] == '1') {
        echo '<div class="notice notice-success is-dismissible">
                <p>Deine Preise wurden erfolgreich gespeichert!</p>
              </div>';
    }
});
