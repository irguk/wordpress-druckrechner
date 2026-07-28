<?php
/*
Plugin Name: Druckrechner
Description: Ein einfacher Produktrechner für Format, Grammatur, Seitendruck und weitere Optionen.
Version: 1.0
Author: Iryna
*/

defined('ABSPATH') || exit; // Sicherheit: Direktzugriff verhindern

// 🔧 Pfade definieren
define('DRUCKRECHNER_PATH', plugin_dir_path(__FILE__));
define('DRUCKRECHNER_URL', plugin_dir_url(__FILE__));

// Wird beim Aktivieren des Plugins ausgeführt
register_activation_hook(__FILE__, 'druckrechner_create_plugin_tables');

// 🔧 Skripte und Styles einbinden
function druckrechner_enqueue_scripts() {
    // JavaScript für Vorschau
    wp_enqueue_script(
        'druckrechner-preview',
        DRUCKRECHNER_URL . 'assets/js/preview.js',
        array('jquery'),
        '1.0',
        true
    );

    // JavaScript für Kalkulation
   // wp_enqueue_script(
   //     'druckkalkulation-js',
     //   DRUCKRECHNER_URL . 'assets/js/druckkalkulation.js',
    //    array('jquery'),
    //    '1.0',
    //    true
    //);

    // CSS
    wp_enqueue_style(
        'druckrechner-style',
        DRUCKRECHNER_URL . 'assets/css/style.css',
        array(),
        '1.0'
    );

 
    
    // AJAX URL verfügbar machen - привязываем к 'druckrechner-preview'
    wp_localize_script('druckrechner-preview', 'ajaxurl', array(
        'url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'druckrechner_enqueue_scripts');

// Filter, um den Text im linken Footer zu entfernen
function druckrechner_admin_footer_text_entfernen( $default_text ) {
    return ''; 
}
add_filter( 'admin_footer_text', 'druckrechner_admin_footer_text_entfernen' );

// Filter, um die Versionsnummer (rechter Footer) zu entfernen
function druckrechner_admin_footer_version_entfernen() {
    return '';
}
add_filter( 'update_footer', 'druckrechner_admin_footer_version_entfernen', 11 );


// 🔧 Plugin-Dateien laden
require_once DRUCKRECHNER_PATH . 'includes/assets.php';
require_once DRUCKRECHNER_PATH . 'includes/shortcode.php';
require_once DRUCKRECHNER_PATH . 'includes/ajax-handler.php';
require_once DRUCKRECHNER_PATH . 'includes/helpers.php';
require_once DRUCKRECHNER_PATH . 'admin/submenu.php';
require_once DRUCKRECHNER_PATH . 'admin/create-table.php';
require_once DRUCKRECHNER_PATH . 'admin/druckrechner-handle-form.php';
require_once DRUCKRECHNER_PATH . 'admin/notices.php';
require_once DRUCKRECHNER_PATH . 'admin/speicher-callback.php';
require_once DRUCKRECHNER_PATH . 'admin/discount-handler.php'; // Neue Datei für die Rabatt-Logik
