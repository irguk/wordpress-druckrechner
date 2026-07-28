<?php
/**
 * Datei: ajax-handler.php
 * VOLLSTÄNDIG KORRIGIERT: Behebt undefinierte Variablen und fügt Extra-Logik hinzu.
 */

if ( ! function_exists( 'druckrechner_ajax_handler' ) ) {
    add_action('wp_ajax_druckrechner_ajax', 'druckrechner_ajax_handler');
    add_action('wp_ajax_nopriv_druckrechner_ajax', 'druckrechner_ajax_handler');

    function druckrechner_ajax_handler() {
        global $wpdb;
        $table_staffel = $wpdb->prefix . 'druck_staffelpreise';
        $table_preis   = $wpdb->prefix . 'druck_preis';

        // 1. EINGABEN AUSLESEN
        $format      = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : 'A4';
        $grammatur   = isset($_POST['grammatur']) ? sanitize_text_field($_POST['grammatur']) : '';
        $seitendruck = isset($_POST['seitendruck']) ? sanitize_text_field($_POST['seitendruck']) : 'einseitig';
        $mwstTyp     = isset($_POST['mwst']) ? sanitize_text_field($_POST['mwst']) : 'privat';

        $exemplare   = max(1, isset($_POST['exemplare']) ? intval($_POST['exemplare']) : 1);
        $seiten      = max(0, isset($_POST['seiten']) ? intval($_POST['seiten']) : 0); 
        $farbseiten  = max(0, isset($_POST['farbseiten']) ? intval($_POST['farbseiten']) : 0); 
        $sw_seiten   = max(0, $seiten - $farbseiten);

        // Bindung & Optionen
        $bindungsart = isset($_POST['bindungsart']) ? sanitize_text_field($_POST['bindungsart']) : '';
        $einband     = isset($_POST['einband']) ? sanitize_text_field($_POST['einband']) : '';
        $praegung    = isset($_POST['praegung']) ? sanitize_text_field($_POST['praegung']) : 'nein';
        $schriftart  = isset($_POST['schriftart']) ? sanitize_text_field($_POST['schriftart']) : '';
        $farbe       = isset($_POST['farbe']) ? sanitize_text_field($_POST['farbe']) : ''; // Prägefarbe
        
        // Einbände & Farben
        $ev               = isset($_POST['ev']) ? sanitize_text_field($_POST['ev']) : '';
        $eh               = isset($_POST['eh']) ? sanitize_text_field($_POST['eh']) : '';
        $ringfarbe        = isset($_POST['ringfarbe']) ? sanitize_text_field($_POST['ringfarbe']) : '';
        $faelzelbandfarbe = isset($_POST['faelzelbandfarbe']) ? sanitize_text_field($_POST['faelzelbandfarbe']) : '';
        $kammfarbe        = isset($_POST['kammfarbe']) ? sanitize_text_field($_POST['kammfarbe']) : '';

        $cd              = isset($_POST['cd']) ? sanitize_text_field($_POST['cd']) : 'nein';
        $cd_stueck       = max(0, isset($_POST['cd_stueck']) ? intval($_POST['cd_stueck']) : 0);
        $cd_huelle       = isset($_POST['cd_huelle']) ? sanitize_text_field($_POST['cd_huelle']) : 'nein';
        $cd_direktdruck  = isset($_POST['cd_direktdruck']) ? sanitize_text_field($_POST['cd_direktdruck']) : 'nein';

        $einzelpreis = 0.00;

        // --- 2. FORMAT-BASISPREIS (0,90 € Logik) ---
        if ($format === 'A4') {
            $p_format = (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_preis WHERE name = 'formatA4'"));
            $einzelpreis += ($p_format ?: 0.84); 
        } elseif ($format === 'A5') {
            $einzelpreis += (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_preis WHERE name = 'formatA5'"));
        }

        // --- 3. DRUCKKOSTEN (STAFFEL) ---
        $p_bw = (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_staffel WHERE name = 'seiten_bw' AND %d BETWEEN seiten_ab AND seiten_bis LIMIT 1", $sw_seiten));
        $einzelpreis += ($sw_seiten * ($p_bw ?: 0.06));

        $p_cl = (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_staffel WHERE name = 'seiten_cl' AND %d BETWEEN seiten_ab AND seiten_bis LIMIT 1", $farbseiten));
        $einzelpreis += ($farbseiten * ($p_cl ?: 0.45));

        // --- 4. PAPIER & SEITENMODUS ---
        if (!empty($grammatur) && $grammatur != '80') {
            $p_pap = (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_staffel WHERE name = %s LIMIT 1", 'grammatur' . $grammatur));
            $einzelpreis += ($seiten * $p_pap);
        }
        if ($seitendruck === 'beidseitig') {
            $einzelpreis += (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_preis WHERE name = 'Beidseitig'"));
        }

        // --- 5. BINDUNG (STAFFEL) ---
        if (!empty($bindungsart) && $bindungsart !== 'ohne_bindung') {
            $p_bind = (float) $wpdb->get_var($wpdb->prepare(
                "SELECT preis FROM $table_staffel WHERE name = %s AND %d BETWEEN seiten_ab AND seiten_bis AND menge_ab <= %d ORDER BY menge_ab DESC LIMIT 1",
                $bindungsart, $seiten, $exemplare
            ));
            $einzelpreis += $p_bind;
        }

        // --- 6. EXTRAS (EINBÄNDE, PRÄGUNG, FARBEN) ---
        if ($praegung === 'ja') {
            $einzelpreis += (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_preis WHERE name = 'praegung_checkbox'"));
        }

        // Liste aller Fixpreis-Optionen aus der Datenbank abfragen
        $extra_fields = [$ev, $eh, $ringfarbe, $kammfarbe, $farbe, $schriftart];
        foreach ($extra_fields as $val) {
            if (!empty($val)) {
                $einzelpreis += (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_preis WHERE name = %s", $val));
            }
        }

        // CD Logik
        if ($cd === 'ja' && $cd_stueck > 0) {
            $p_cd = (float) $wpdb->get_var($wpdb->prepare("SELECT preis FROM $table_preis WHERE name = 'cd'"));
            $einzelpreis += ($p_cd * $cd_stueck);
        }

        // --- 7. GESAMTBERECHNUNG ---
        $gesamtpreisNetto = $einzelpreis * $exemplare;
        $mwstSatz = ($mwstTyp === 'firma') ? 0.19 : 0.07;
        $bruttopreis = $gesamtpreisNetto * (1 + $mwstSatz);

        // --- 8. ANTWORT ---
        $response = array(
            'ok'            => true,
            'format'        => $format,
            'grammatur'     => $grammatur . 'g',
            'seitendruck'   => $seitendruck,
            'exemplare'     => $exemplare,
            'seiten'        => $seiten,
            'farbseiten'    => $farbseiten,
            'bindungsart'   => $bindungsart,
            'einband'       => $einband,
            'praegung'      => $praegung,
            'ev'            => $ev,
            'eh'            => $eh,
            'einzelpreis'   => number_format($einzelpreis, 2, ',', '.'),
            'gesamtpreis'   => number_format($gesamtpreisNetto, 2, ',', '.'),
            'bruttopreis'   => number_format($bruttopreis, 2, ',', '.'),
            'mwst'          => ($mwstSatz * 100) . '%'
        );

        wp_send_json($response);
        wp_die();
    }
}