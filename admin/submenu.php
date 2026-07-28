<?php
defined('ABSPATH') || exit;

// Admin-Menü registrieren
function druckrechner_admin_menu() {
    // 1. Hauptseite
    add_menu_page(
        esc_html__( 'DruckRechner Admin Page', 'druckrechner' ),
        esc_html__( 'DruckRechner Admin Page', 'druckrechner' ),
        'manage_options',
        'dlx-admin-menu',
        'druckrechner_admin_menu_callback',
        'dashicons-admin-generic',
        80
    );

    // 2. NEU: Unterseite für Rabatt-Tabellen
    add_submenu_page(
        'dlx-admin-menu', // Eltern-Slug (muss mit der ID oben übereinstimmen)
        esc_html__( 'Bindungspreise & Rabatte', 'druckrechner' ),
        esc_html__( 'Rabatt-Tabellen', 'druckrechner' ),
        'manage_options',
        'druckrechner-discounts', // Eigener Slug für die Rabatt-Seite
        'druckrechner_discount_menu_callback' // Neue Callback-Funktion
    );
}
add_action('admin_menu', 'druckrechner_admin_menu');

// Callback für die Hauptseite
function druckrechner_admin_menu_callback() {
    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('DruckRechner Preis Page', 'druckrechner') . '</h1>';
    include DRUCKRECHNER_PATH . 'admin/submenu-page.php';
    echo '</div>';
}

// NEU: Callback für die Rabatt-Seite
function druckrechner_discount_menu_callback() {
    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Bindungspreise & Rabatte', 'druckrechner') . '</h1>';
    // Hier kannst du eine neue Datei erstellen, z.B. discount-table-page.php
    include DRUCKRECHNER_PATH . 'admin/discount-table-page.php';
    echo '</div>';
}

