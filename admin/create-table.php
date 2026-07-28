<?php

function druckrechner_create_plugin_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // --- TABELLE 1: BASIS-PREISE (Format, Papier, etc.) ---
    $table_preis = $wpdb->prefix . 'druck_preis';
    $sql1 = "CREATE TABLE $table_preis (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        preis float NOT NULL, 
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta($sql1);

    // --- TABELLE 2: STAFFELPREISE (Bindung, Mengenrabatte) ---
    // Spalten: Name, Preis, Seiten ab, Seiten bis, Menge (Exemplare)
    $table_staffel = $wpdb->prefix . 'druck_staffelpreise';
    $sql2 = "CREATE TABLE $table_staffel (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,      -- Name der Bindung (z.B. premium_lederoptik)
        preis decimal(10,2) NOT NULL,    -- Der Preis für diese Staffel
        seiten_ab int(11) DEFAULT 0,     -- Ab wie vielen Seiten?
        seiten_bis int(11) DEFAULT 9999, -- Bis wie viele Seiten?
        menge_ab int(11) DEFAULT 1,      -- Ab welcher Stückzahl (Exemplare)?
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta($sql2);
}

// Registriere die Funktion für die Plugin-Aktivierung
register_activation_hook(__FILE__, 'druckrechner_create_plugin_tables');