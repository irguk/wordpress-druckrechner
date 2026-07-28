<?php
defined('ABSPATH') || exit;

// 1. Speichern der Änderungen
add_action('admin_post_druckrechner_speichern_staffel', function() {
    check_admin_referer('staffel_save_action', 'staffel_nonce');
    if (!current_user_can('manage_options')) wp_die('Keine Berechtigung');

    global $wpdb;
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';

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
    wp_redirect(admin_url('admin.php?page=druckrechner-discounts&saved=1')); // Passe den Page-Slug an
    exit;
});

// 2. Neue Preisstufe hinzufügen
add_action('admin_post_druckrechner_add_staffel', function() {
    check_admin_referer('staffel_add_action', 'staffel_add_nonce');
    global $wpdb;
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';

    $wpdb->insert($table_staffel, array(
        'name'       => sanitize_text_field($_POST['new_name']),
        'seiten_ab'  => intval($_POST['new_seiten_ab']),
        'seiten_bis' => 9999,
        'menge_ab'   => intval($_POST['new_menge_ab']),
        'preis'      => floatval(str_replace(',', '.', $_POST['new_preis']))
    ));
    wp_redirect(admin_url('admin.php?page=druckrechner-discounts&saved=1'));
    exit;
});

// 3. Löschen einer Stufe
add_action('admin_post_druckrechner_delete_staffel', function() {
    if (!current_user_can('manage_options')) wp_die('Keine Berechtigung');
    
    global $wpdb;
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';
    $id = intval($_GET['id']);

    $wpdb->delete($table_staffel, array('id' => $id));
    wp_redirect(admin_url('admin.php?page=druckrechner-discounts&deleted=1'));
    exit;
});