<?php
defined('ABSPATH') || exit;

/**
 * 1. Callback für das Hauptformular (Allgemeine Preise)
 */
add_action('admin_post_druckrechner_speichern', 'druckrechner_speichern_callback');
function druckrechner_speichern_callback() {
    if (!isset($_POST['druckrechner_nonce']) || !wp_verify_nonce($_POST['druckrechner_nonce'], 'druckrechner_form_action')) {
        wp_die('Sicherheitscheck fehlgeschlagen.');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Keine Berechtigung.');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'druck_preis';

    // Logik für allgemeine Preise (falls du diese über das Hauptformular sendest)
    if (isset($_POST['prices']) && is_array($_POST['prices'])) {
        foreach ($_POST['prices'] as $name => $preis) {
            $wpdb->update(
                $table_name,
                array('preis' => sanitize_text_field($preis)),
                array('name' => sanitize_text_field($name))
            );
        }
    }

    wp_safe_redirect(admin_url('admin.php?page=dlx-admin-menu&saved=1'));
    exit;
}

/**
 * 2. Callback für die neue Staffelpreis-Tabelle (ehemals Matrix)
 */
add_action('admin_post_druckrechner_speichern_staffel', 'druckrechner_save_staffel_callback');
function druckrechner_save_staffel_callback() {
    // Sicherheit prüfen
    if (!isset($_POST['staffel_nonce']) || !wp_verify_nonce($_POST['staffel_nonce'], 'staffel_save_action')) {
        wp_die('Sicherheitscheck fehlgeschlagen.');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Keine Berechtigung.');
    }

    global $wpdb;
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';

    // Daten aus dem Formular verarbeiten
    if (isset($_POST['rows']) && is_array($_POST['rows'])) {
        foreach ($_POST['rows'] as $id => $data) {
            $wpdb->update(
                $table_staffel,
                array(
                    'seiten_ab'  => intval($data['seiten_ab']),
                    'seiten_bis' => intval($data['seiten_bis']),
                    'menge_ab'   => intval($data['menge_ab']),
                    'preis'      => floatval(str_replace(',', '.', $data['preis']))
                ),
                array('id' => intval($id))
            );
        }
    }

    wp_safe_redirect(admin_url('admin.php?page=druckrechner-discounts&saved=1'));
    exit;
}

/**
 * 3. Callback zum Hinzufügen einer neuen Preisstufe
 */
add_action('admin_post_druckrechner_add_staffel', 'druckrechner_add_staffel_callback');
function druckrechner_add_staffel_callback() {
    check_admin_referer('staffel_add_action', 'staffel_add_nonce');
    
    global $wpdb;
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';

    $wpdb->insert($table_staffel, array(
        'name'       => sanitize_text_field($_POST['new_name']),
        'seiten_ab'  => intval($_POST['new_seiten_ab']),
        'seiten_bis' => 9999, // Standardwert
        'menge_ab'   => intval($_POST['new_menge_ab']),
        'preis'      => floatval(str_replace(',', '.', $_POST['new_preis']))
    ));

    wp_safe_redirect(admin_url('admin.php?page=druckrechner-discounts&saved=1'));
    exit;
}

/**
 * 4. Callback zum Löschen einer Preisstufe
 */
add_action('admin_post_druckrechner_delete_staffel', 'druckrechner_delete_staffel_callback');
function druckrechner_delete_staffel_callback() {
    if (!current_user_can('manage_options')) {
        wp_die('Keine Berechtigung.');
    }

    global $wpdb;
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';
    $id = intval($_GET['id']);

    if ($id > 0) {
        $wpdb->delete($table_staffel, array('id' => $id));
    }

    wp_safe_redirect(admin_url('admin.php?page=druckrechner-discounts&deleted=1'));
    exit;
}