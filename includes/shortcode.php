<?php
/**
 * /includes/shortcode.php
 * Korrigierte Version: Verarbeitet jetzt auch das finale Absenden
 */

if ( ! session_id() && ! headers_sent() ) {
    session_start();
}

add_shortcode( 'druckrechner', 'druckrechner_shortcode' );

function druckrechner_shortcode() {
    if ( ! defined( 'DRUCKRECHNER_PATH' ) ) {
        return "<p style='color:red;'>Fehler: DRUCKRECHNER_PATH nicht definiert.</p>";
    }

    $template_dir = DRUCKRECHNER_PATH . 'templates/';

    // --- 1. DATEN-VERARBEITUNG (LOGIK) ---

    // A. RESET
    if ( $_SERVER['REQUEST_METHOD'] !== 'POST' && ! isset( $_GET['step'] ) ) {
        unset( $_SESSION['step1_data'], $_SESSION['step2_data'] );
    }

    // B. SCHRITT 1 -> 2
    if ( isset( $_POST['step1_submit'] ) ) {
        $_SESSION['step1_data'] = $_POST;
    }

    // C. ZURÜCK SCHRITT 3 -> 2
    if ( isset( $_POST['go_back_to_step2'] ) ) {
        unset( $_SESSION['step2_data'] );
    }

    // D. SCHRITT 2 -> 3
    if ( isset( $_POST['step2_submit'] ) ) {
        $_SESSION['step2_data'] = $_POST;
    }

    // E. FINALES ABSENDEN (SCHRITT 3)
    // WICHTIG: Diese Prüfung muss VOR der Template-Anzeige kommen!
    if ( isset( $_POST['final_submit'] ) ) {
        return druckrechner_process_final_order($template_dir);
    }

    // --- 2. TEMPLATE ANZEIGE ---

    if ( isset( $_SESSION['step1_data'] ) && isset( $_SESSION['step2_data'] ) ) {
        return druckrechner_load_template( $template_dir . 'step-3.php' );
    } 
    
    if ( isset( $_SESSION['step1_data'] ) ) {
        return druckrechner_load_template( $template_dir . 'step-2.php' );
    }

    return druckrechner_load_template( $template_dir . 'form.php' );
}

/**
 * ÜBERARBEITETE FUNKTION FÜR DEN VERSAND
 */
function druckrechner_process_final_order( $template_dir ) {
    if ( ! isset( $_SESSION['step1_data'] ) || ! isset( $_SESSION['step2_data'] ) ) {
        return "<p style='color:red;'>Session abgelaufen.</p>" . druckrechner_load_template( $template_dir . 'form.php' );
    }

    $data1 = $_SESSION['step1_data'];
    $data2 = $_SESSION['step2_data'];
    $data3 = $_POST;

    // Datei-Upload Logik
    $attachments = array(); // Array für wp_mail Anhänge
    $upload_info = "Kein Datei-Upload.";

    if ( ! empty( $_FILES['uploaded_file']['name'] ) ) {
        $upload_dir = WP_CONTENT_DIR . '/uploads/drucker_bestellungen/';
        if ( ! is_dir( $upload_dir ) ) wp_mkdir_p( $upload_dir );

        $file_name = sanitize_file_name( $_FILES['uploaded_file']['name'] );
        $final_path = $upload_dir . uniqid() . '-' . $file_name;

        if ( move_uploaded_file( $_FILES['uploaded_file']['tmp_name'], $final_path ) ) {
            $upload_info = "Datei erfolgreich hochgeladen.";
            $attachments[] = $final_path; // Datei direkt an die Mail hängen!
        }
    }

    // Email-Inhalt schöner formatieren
    $admin_email = get_option( 'admin_email' );
    $subject = "Neue Druckbestellung: " . $data2['vorname'] . " " . $data2['nachname'];
    
    $message = "NEUE BESTELLUNG\n\n";
    $message .= "KUNDE: " . $data2['vorname'] . " " . $data2['nachname'] . "\n";
    $message .= "EMAIL: " . $data2['email'] . "\n";
    $message .= "NACHRICHT: " . ($data3['message'] ?? 'Keine') . "\n\n";
    $message .= "DETAILS AUS SCHRITT 1:\n";
    foreach($data1 as $k => $v) { if(!is_array($v)) $message .= "$k: $v\n"; }

    // E-Mail senden
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    wp_mail( $admin_email, $subject, $message, $headers, $attachments );

    // Session löschen
    unset( $_SESSION['step1_data'], $_SESSION['step2_data'] );

    return "<h2>🎉 Vielen Dank!</h2><p>Ihre Bestellung wurde erfolgreich an uns übermittelt.</p>";
}

function druckrechner_load_template( $template_path ) {
    if ( file_exists( $template_path ) ) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    }
    return "<p style='color:red;'>Fehler: Template fehlt.</p>";
}