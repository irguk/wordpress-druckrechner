<?php
// druckrechner-functions.php

// Diese Funktion muss existieren, falls nicht: Fügen Sie sie hinzu.
function druckrechner_get_raw_preis( $name ) {
    global $wpdb;
    $table = $wpdb->prefix . 'druck_preis';
    $preis = $wpdb->get_var( $wpdb->prepare(
        "SELECT preis FROM $table WHERE name = %s", $name
    ) );
    return (float) $preis; 
}

// Ergänzung: Funktion zur Anzeige des formatierten Preises, da diese im Formular verwendet wird.
if ( ! function_exists( 'druckrechner_get_aktueller_preis' ) ) {
    function druckrechner_get_aktueller_preis( $name ) {
        // Annahme: Formatiert als "X,XX €"
        return number_format(druckrechner_get_raw_preis($name), 2, ',', '') . ' €'; 
    }
}

// **********************************************
// DATENBANK-ABRUF FÜR DIE FORMULARANSICHT
// **********************************************

// Werte abrufen und Variablen zuweisen:
$raw_price_a5 = druckrechner_get_raw_preis('Format A5');
$raw_price_a4 = druckrechner_get_raw_preis('Format A4');

// Bitte beachten Sie: Für die anderen Felder (Grammatur, Seitendruck) müssten
// hier ähnliche Zeilen eingefügt werden, damit die Werte in der Form geladen werden können.
// Zum Beispiel: $raw_price_grammatur80 = druckrechner_get_raw_preis('Grammatur 80');
?>