<?php
function druckrechner_enqueue_assets() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('druckrechner-preview', DRUCKRECHNER_URL . 'assets/js/preview.js', array('jquery'), null, true);
    wp_enqueue_script('druckrechner-preisrechner', DRUCKRECHNER_URL . 'assets/js/preisrechner.js', array('jquery'), null, true);
    wp_enqueue_style('druckrechner-style', DRUCKRECHNER_URL . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'druckrechner_enqueue_assets');
