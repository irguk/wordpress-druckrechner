<?php
/**
 * Hauptfunktion zur Verarbeitung des Admin-Formulars (Speichern der Preise).
 */
function druckrechner_handle_form() {
    
    // 1. SICHERHEITSPRÜFUNGEN (MUSS IMMER ZUERST KOMMEN)
    
    // Prüfen, ob der Benutzer die Berechtigung hat (z.B. Administrator)
    if (!current_user_can('manage_options')) {
        wp_die('Keine Berechtigung');
    }

    // Prüfen der Nonce für die Sicherheit der Anfrage
    if (!isset($_POST['druckrechner_nonce']) || 
        !wp_verify_nonce($_POST['druckrechner_nonce'], 'druckrechner_form_action')) {
        wp_die('Ungültige Anfrage');
    }

    // --- Start der Datenverarbeitung ---
    global $wpdb;
    $table = $wpdb->prefix . 'druck_preis';

    // 2. DATENABRUF UND LOGIK (Wenn Feld leer, behalte den alten Wert)
    
    // Format A4
    $post_formatA4 = isset($_POST['formatA4']) ? trim($_POST['formatA4']) : '';
    // Holt alten Preis, falls Feld leer, sonst nimmt es den neuen Float-Wert
    $formatA4_to_save = ($post_formatA4 === '') ? druckrechner_get_raw_preis('formatA4') : floatval($post_formatA4);
    
    // Format A5
    $post_formatA5 = isset($_POST['formatA5']) ? trim($_POST['formatA5']) : '';
    $formatA5_to_save = ($post_formatA5 === '') ? druckrechner_get_raw_preis('formatA5') : floatval($post_formatA5);


    // Grammatur 80
    $post_grammatur80 = isset($_POST['grammatur80']) ? trim($_POST['grammatur80']) : '';
    $grammatur80_to_save = ($post_grammatur80 === '') ? druckrechner_get_raw_preis('grammatur80') : floatval($post_grammatur80);

    // Grammatur 100
    $post_grammatur100 = isset($_POST['grammatur100']) ? trim($_POST['grammatur100']) : '';
    $grammatur100_to_save = ($post_grammatur100 === '') ? druckrechner_get_raw_preis('grammatur100') : floatval($post_grammatur100);
    
    // Grammatur 120
    $post_grammatur120 = isset($_POST['grammatur120']) ? trim($_POST['grammatur120']) : '';
    $grammatur120_to_save = ($post_grammatur120 === '') ? druckrechner_get_raw_preis('grammatur120') : floatval($post_grammatur120);

    
    // Einseitig
    $post_Eins = isset($_POST['einseitig']) ? trim($_POST['einseitig']) : '';
    $einseitig_to_save = ($post_Eins === '') ? druckrechner_get_raw_preis('einseitig') : floatval($post_Eins);
    
    // Beidseitig
    $post_Beids = isset($_POST['beidseitig']) ? trim($_POST['beidseitig']) : '';
    $beidseitig_to_save = ($post_Beids === '') ? druckrechner_get_raw_preis('beidseitig') : floatval($post_Beids);

    // 4. Seiten
    $post_Seit = isset($_POST['seiten']) ? trim($_POST['seiten']) : '';
    $seiten_to_save = ($post_Seit === '') ? druckrechner_get_raw_preis('seiten') : floatval($post_Seit);
    
    // 5. Farbseiten
    $post_Farb = isset($_POST['farbseiten']) ? trim($_POST['farbseiten']) : '';
    $farbseit_to_save = ($post_Farb === '') ? druckrechner_get_raw_preis('farbseiten') : floatval($post_Farb);

    // 6. Exemplare
   // $post_Exem = isset($_POST['anzahl_exemplare']) ? trim($_POST['anzahl_exemplare']) : '';
    //$exemplare_to_save = ($post_Exem === '') ? druckrechner_get_raw_preis('Exemplare') : floatval($post_Exem);


// --- 7.1 Premium Lederoptik ---
$post_bind_preled = isset($_POST['bindung_premium_lederoptik']) ? trim($_POST['bindung_premium_lederoptik']) : '';
$preleder_to_save = ($post_bind_preled === '') ? druckrechner_get_raw_preis('bindung_premium_lederoptik') : floatval($post_bind_preled);

$post_einband_preled_bord = isset($_POST['einband_premium_lederoptik_bordeaux']) ? trim($_POST['einband_premium_lederoptik_bordeaux']) : '';
$einband_preled_bord_to_save = ($post_einband_preled_bord === '') ? druckrechner_get_raw_preis('einband_premium_lederoptik_bordeaux') : floatval($post_einband_preled_bord);

$post_einband_preled_blau = isset($_POST['einband_premium_lederoptik_blau']) ? trim($_POST['einband_premium_lederoptik_blau']) : '';
$einband_preled_blau_to_save = ($post_einband_preled_blau === '') ? druckrechner_get_raw_preis('einband_premium_lederoptik_blau') : floatval($post_einband_preled_blau);

$post_einband_preled_anthr = isset($_POST['einband_premium_lederoptik_anthrazit']) ? trim($_POST['einband_premium_lederoptik_anthrazit']) : '';
$einband_preled_anthr_to_save = ($post_einband_preled_anthr === '') ? druckrechner_get_raw_preis('einband_premium_lederoptik_anthrazit') : floatval($post_einband_preled_anthr);

$post_einband_preled_schwa = isset($_POST['einband_premium_lederoptik_schwarz']) ? trim($_POST['einband_premium_lederoptik_schwarz']) : '';
$einband_preled_schwa_to_save = ($post_einband_preled_schwa === '') ? druckrechner_get_raw_preis('einband_premium_lederoptik_schwarz') : floatval($post_einband_preled_schwa);


// --- 7.2 Klemmbuch ---
$post_Klemm = isset($_POST['bindung_klemmbuch']) ? trim($_POST['bindung_klemmbuch']) : '';
$klemmbuch_to_save = ($post_Klemm === '') ? druckrechner_get_raw_preis('bindung_klemmbuch') : floatval($post_Klemm);

$post_einband_klemm_bord = isset($_POST['einband_klemmbuch_bordeaux']) ? trim($_POST['einband_klemmbuch_bordeaux']) : '';
$einband_klemm_bord_to_save = ($post_einband_klemm_bord === '') ? druckrechner_get_raw_preis('einband_klemmbuch_bordeaux') : floatval($post_einband_klemm_bord);

$post_einband_klemm_blau = isset($_POST['einband_klemmbuch_blau']) ? trim($_POST['einband_klemmbuch_blau']) : '';
$einband_klemm_blau_to_save = ($post_einband_klemm_blau === '') ? druckrechner_get_raw_preis('einband_klemmbuch_blau') : floatval($post_einband_klemm_blau);

$post_einband_klemm_grun = isset($_POST['einband_klemmbuch_grun']) ? trim($_POST['einband_klemmbuch_grun']) : '';
$einaband_klemm_grun_to_save = ($post_einband_klemm_grun === '') ? druckrechner_get_raw_preis('einband_klemmbuch_grun') : floatval($post_einband_klemm_grun);

$post_einband_klemm_beige = isset($_POST['einband_klemmbuch_beige']) ? trim($_POST['einband_klemmbuch_beige']) : '';
$einband_klemm_beige_to_save = ($post_einband_klemm_beige === '') ? druckrechner_get_raw_preis('einband_klemmbuch_beige') : floatval($post_einband_klemm_beige);


// --- 7.3 Premium Kaschmirleinenoptik ---
$post_Pre_kaschmir = isset($_POST['bindung_premium_kaschmirleinenoptik']) ? trim($_POST['bindung_premium_kaschmirleinenoptik']) : '';
$prekaschmir_to_save = ($post_Pre_kaschmir === '') ? druckrechner_get_raw_preis('bindung_premium_kaschmirleinenoptik') : floatval($post_Pre_kaschmir);

$post_einband_pre_kasch_blau = isset($_POST['einband_premium_kaschmirleinenoptik_blau']) ? trim($_POST['einband_premium_kaschmirleinenoptik_blau']) : '';
$einband_prekasch_blau_to_save = ($post_einband_pre_kasch_blau === '') ? druckrechner_get_raw_preis('einband_premium_kaschmirleinenoptik_blau') : floatval($post_einband_pre_kasch_blau);

$post_einband_pre_kasch_beige = isset($_POST['einband_premium_kaschmirleinenoptik_beige']) ? trim($_POST['einband_premium_kaschmirleinenoptik_beige']) : '';
$einband_prekasch_beige_to_save = ($post_einband_pre_kasch_beige === '') ? druckrechner_get_raw_preis('einband_premium_kaschmirleinenoptik_beige') : floatval($post_einband_pre_kasch_beige);

$post_einband_pre_kasch_dungrau = isset($_POST['einband_premium_kaschmirleinenoptik_dunkelgrau']) ? trim($_POST['einband_premium_kaschmirleinenoptik_dunkelgrau']) : '';
$einband_prekasch_dungrau_to_save = ($post_einband_pre_kasch_dungrau === '') ? druckrechner_get_raw_preis('einband_premium_kaschmirleinenoptik_dunkelgrau') : floatval($post_einband_pre_kasch_dungrau);

// --- 7.4 Premium Plastringbindung, Drahtringbindung ---

$post_plastringbindung = isset($_POST['bindung_plastringbindung']) ? trim($_POST['bindung_plastringbindung']) : '';
$plastring_to_save = ($post_plastringbindung === '') ? druckrechner_get_raw_preis('bindung_plastringbindung') : floatval($post_plastringbindung);

$post_drahtringbindung = isset($_POST['bindung_drahtringbindung']) ? trim($_POST['bindung_drahtringbindung']) : '';
$drachtring_to_save = ($post_drahtringbindung === '') ? druckrechner_get_raw_preis('bindung_drahtringbindung') : floatval($post_drahtringbindung);



// --- 7.6 Fälzelband ---
$post_Faelzel = isset($_POST['bindung_faelzelband']) ? trim($_POST['bindung_faelzelband']) : '';
$faelzel_to_save = ($post_Faelzel === '') ? druckrechner_get_raw_preis('bindung_faelzelband') : floatval($post_Faelzel);

$post_einband_faelz_blau = isset($_POST['einband_faelzelband_blau']) ? trim($_POST['einband_faelzelband_blau']) : '';
$einband_faelz_blau_to_save = ($post_einband_faelz_blau === '') ? druckrechner_get_raw_preis('einband_faelzelband_blau') : floatval($post_einband_faelz_blau);

$post_einband_faelz_bord = isset($_POST['einband_faelzelband_bordeaux']) ? trim($_POST['einband_faelzelband_bordeaux']) : '';
$einband_faelz_bord_to_save = ($post_einband_faelz_bord === '') ? druckrechner_get_raw_preis('einband_faelzelband_bordeaux') : floatval($post_einband_faelz_bord);

$post_einband_faelz_anthr = isset($_POST['einband_faelzelband_anthrazit']) ? trim($_POST['einband_faelzelband_anthrazit']) : '';
$einband_faelz_anthr_to_save = ($post_einband_faelz_anthr === '') ? druckrechner_get_raw_preis('einband_faelzelband_anthrazit') : floatval($post_einband_faelz_anthr);

$post_einband_faelz_schwa = isset($_POST['einband_faelzelband_schwarz']) ? trim($_POST['einband_faelzelband_schwarz']) : '';
$einband_faelz_schwa_to_save = ($post_einband_faelz_schwa === '') ? druckrechner_get_raw_preis('einband_faelzelband_schwarz') : floatval($post_einband_faelz_schwa);

$post_einband_faelz_grun = isset($_POST['einband_faelzelband_grün']) ? trim($_POST['einband_faelzelband_grün']) : '';
$einband_faelz_grun_to_save = ($post_einband_faelz_grun === '') ? druckrechner_get_raw_preis('einband_faelzelband_grün') : floatval($post_einband_faelz_grun);
    

 // --- 7.7 Heißleimbindung ---
$post_Heisslei = isset($_POST['bindung_heissleimbindung']) ? trim($_POST['bindung_heissleimbindung']) : '';
$heisslei_to_save = ($post_Heisslei === '') ? druckrechner_get_raw_preis('bindung_heissleimbindung') : floatval($post_Heisslei);

// 7.7.1 Heißleimbindung / Einband : eigene geschaltung
$post_einband_heissl_eingesch = isset($_POST['einband_heissleimbindung_eigene_geschaltung']) ? trim($_POST['einband_heissleimbindung_eigene_geschaltung']) : '';
$einband_heissl_eingesch_to_save = ($post_einband_heissl_eingesch === '') ? druckrechner_get_raw_preis('einband_heissleimbindung_eigene_geschaltung') : floatval($post_einband_heissl_eingesch);

// 7.7.2 Heißleimbindung / Einband : vorne hinten blau
$post_einband_heissl_vohitblau = isset($_POST['einband_heissleimbindung_vorne_hinten_blau']) ? trim($_POST['einband_heissleimbindung_vorne_hinten_blau']) : '';
$einband_heissl_vohitblau_to_save = ($post_einband_heissl_vohitblau === '') ? druckrechner_get_raw_preis('einband_heissleimbindung_vorne_hinten_blau') : floatval($post_einband_heissl_vohitblau);

// 7.7.3 Heißleimbindung / Einband : matte hinten blau
$post_einband_heissl_mathinbla = isset($_POST['einband_heissleimbindung_matte_hinten_blau']) ? trim($_POST['einband_heissleimbindung_matte_hinten_blau']) : '';
$einband_heissl_mathinbla_to_save = ($post_einband_heissl_mathinbla === '') ? druckrechner_get_raw_preis('einband_heissleimbindung_matte_hinten_blau') : floatval($post_einband_heissl_mathinbla);

// 7.7.4 Heißleimbindung / Einband : vorne hinten bordeaux
$post_einband_heissl_vorhinbor = isset($_POST['einband_heissleimbindung_vorne_hinten_bordeaux']) ? trim($_POST['einband_heissleimbindung_vorne_hinten_bordeaux']) : '';
$einband_heissl_vorhinbor_to_save = ($post_einband_heissl_vorhinbor === '') ? druckrechner_get_raw_preis('einband_heissleimbindung_vorne_hinten_bordeaux') : floatval($post_einband_heissl_vorhinbor);

// 7.7.5 Heißleimbindung / Einband : matte hinten bordeaux
$post_einband_heissl_mathinbord = isset($_POST['einband_heissleimbindung_matte_hinten_bordeaux']) ? trim($_POST['einband_heissleimbindung_matte_hinten_bordeaux']) : '';
$einband_heissl_mathinbord_to_save = ($post_einband_heissl_mathinbord === '') ? druckrechner_get_raw_preis('einband_heissleimbindung_matte_hinten_bordeaux') : floatval($post_einband_heissl_mathinbord);


// --- 7.8 Kammbindung ---
$post_Kammbind = isset($_POST['bindung_kammbindung']) ? trim($_POST['bindung_kammbindung']) : '';
$kammbind_to_save = ($post_Kammbind === '') ? druckrechner_get_raw_preis('bindung_kammbindung') : floatval($post_Kammbind);


// --- 7.9 Rückstichheftung ---
$post_Ruecks = isset($_POST['bindung_rueckstichheftung']) ? trim($_POST['bindung_rueckstichheftung']) : '';
$rueckstich_to_save = ($post_Ruecks === '') ? druckrechner_get_raw_preis('bindung_rueckstichheftung') : floatval($post_Ruecks);


     // 8 Prägung
    $post_Praegung = isset($_POST['praegung_checkbox']) ? trim($_POST['praegung_checkbox']) : '';
    $praegung_to_save = ($post_Praegung === '') ? druckrechner_get_raw_preis('praegung_checkbox') : floatval($post_Praegung);
    
    // 8.2 Schriftart
    $post_Schrifhelv = isset($_POST['schriftart_helv']) ? trim($_POST['schriftart_helv']) : '';
    $schifhelv_to_save = ($post_Schrifhelv === '') ? druckrechner_get_raw_preis('schriftart_helv') : floatval($post_Schrifhelv);

    // 8.3. Farbe:

    $post_farbe_gold = isset($_POST['farbe_gold']) ? trim($_POST['farbe_gold']) : '';
    $farbe_gold_to_save = ($post_farbe_gold === '') ? druckrechner_get_raw_preis('farbe_gold') : floatval($post_farbe_gold);

    $post_farbe_silber = isset($_POST['farbe_silber']) ? trim($_POST['farbe_silber']) : '';
    $farbe_silber_to_save = ($post_farbe_silber === '') ? druckrechner_get_raw_preis('farbe_silber') : floatval($post_farbe_silber);

    // 9. Einband vorn:
    // 9/1. einband_vorn 
    $post_Ev_foliematt = isset($_POST['ev_folie_matt']) ? trim($_POST['ev_folie_matt']) : '';
    $ev_folimatt_to_save = ($post_Ev_foliematt === '') ? druckrechner_get_raw_preis('ev_folie_matt') : floatval($post_Ev_foliematt);

    $post_Ev_kartonrot = isset($_POST['ev_karton_rot']) ? trim($_POST['ev_karton_rot']) : '';
    $ev_kartrot_to_save = ($post_Ev_kartonrot === '') ? druckrechner_get_raw_preis('ev_karton_rot') : floatval($post_Ev_kartonrot);

    $post_Ev_kartonbord = isset($_POST['ev_karton_bordeaux']) ? trim($_POST['ev_karton_bordeaux']) : '';
    $ev_kartbord_to_save = ($post_Ev_kartonbord === '') ? druckrechner_get_raw_preis('ev_karton_bordeaux') : floatval($post_Ev_kartonbord);


  // 9/2. einband_vorn 

    $post_Ev_kartblau = isset($_POST['ev_karton_blau']) ? trim($_POST['ev_karton_blau']) : '';
    $ev_kartblau_to_save = ($post_Ev_kartblau === '') ? druckrechner_get_raw_preis('ev_karton_blau') : floatval($post_Ev_kartblau);

    $post_Ev_karthellblau = isset($_POST['ev_karton_hellblau']) ? trim($_POST['ev_karton_hellblau']) : '';
    $ev_karthellblau_to_save = ($post_Ev_karthellblau === '') ? druckrechner_get_raw_preis('ev_karton_hellblau') : floatval($post_Ev_karthellblau);

    $post_Ev_kartolive = isset($_POST['ev_karton_olive']) ? trim($_POST['ev_karton_olive']) : '';
    $ev_kartolive_to_save = ($post_Ev_kartolive === '') ? druckrechner_get_raw_preis('ev_karton_olive') : floatval($post_Ev_kartolive);


    // 9.3 Einband_vorn 3 Gruppe

    $post_Ev_kartgrun = isset($_POST['ev_karton_grun']) ? trim($_POST['ev_karton_grun']) : '';
    $ev_kartgrun_to_save = ($post_Ev_kartgrun === '') ? druckrechner_get_raw_preis('ev_karton_grun') : floatval($post_Ev_kartgrun);

    $post_Ev_kartgelb = isset($_POST['ev_karton_gelb']) ? trim($_POST['ev_karton_gelb']) : '';
    $ev_kartgelb_to_save = ($post_Ev_kartgelb === '') ? druckrechner_get_raw_preis('ev_karton_gelb') : floatval($post_Ev_kartgelb);

    $post_Ev_kartweiss = isset($_POST['ev_karton_weiss']) ? trim($_POST['ev_karton_weiss']) : '';
    $ev_kartweiss_to_save = ($post_Ev_kartweiss === '') ? druckrechner_get_raw_preis('ev_karton_weiss') : floatval($post_Ev_kartweiss);

    //9/4. einband_vorn 


    $post_Ev_kartgrau = isset($_POST['ev_karton_grau']) ? trim($_POST['ev_karton_grau']) : '';
    $ev_kartgrau_to_save = ($post_Ev_kartgrau === '') ? druckrechner_get_raw_preis('ev_karton_grau') : floatval($post_Ev_kartgrau);

    $post_Ev_kartschwarz = isset($_POST['ev_karton_schwarz']) ? trim($_POST['ev_karton_schwarz']) : '';
    $ev_kartschwarz_to_save = ($post_Ev_kartschwarz === '') ? druckrechner_get_raw_preis('ev_karton_schwarz') : floatval($post_Ev_kartschwarz);


        // 10. Einband hinten:
    // <!-- 10/1 Gruppe -->
    $post_eh_folie_matt = isset($_POST['eh_folie_matt']) ? trim($_POST['eh_folie_matt']) : '';
    $eh_folimatt_to_save = ($post_eh_folie_matt === '') ? druckrechner_get_raw_preis('eh_folie_matt') : floatval($post_eh_folie_matt);

    $post_eh_kartonrot = isset($_POST['eh_karton_rot']) ? trim($_POST['eh_karton_rot']) : '';
    $eh_kartrot_to_save = ($post_eh_kartonrot === '') ? druckrechner_get_raw_preis('eh_karton_rot') : floatval($post_eh_kartonrot);

    $post_eh_kartonbord = isset($_POST['eh_karton_bordeaux']) ? trim($_POST['eh_karton_bordeaux']) : '';
    $eh_kartbord_to_save = ($post_eh_kartonbord === '') ? druckrechner_get_raw_preis('eh_karton_bordeaux') : floatval($post_eh_kartonbord);

    //10/2 Gruppe -->

    $post_eh_karton_blau = isset($_POST['eh_karton_blau']) ? trim($_POST['eh_karton_blau']) : '';
    $eh_karton_blau_to_save = ($post_eh_karton_blau === '') ? druckrechner_get_raw_preis('eh_karton_blau') : floatval($post_eh_karton_blau);

    $post_eh_kartonhellblau = isset($_POST['eh_karton_hellblau']) ? trim($_POST['eh_karton_hellblau']) : '';
    $eh_karthellblau_to_save = ($post_eh_kartonhellblau === '') ? druckrechner_get_raw_preis('eh_karton_hellblau') : floatval($post_eh_kartonhellblau);

    $post_eh_kartonolive = isset($_POST['eh_karton_olive']) ? trim($_POST['eh_karton_olive']) : '';
    $eh_kartolive_to_save = ($post_eh_kartonolive === '') ? druckrechner_get_raw_preis('eh_karton_olive') : floatval($post_eh_kartonolive);

    $post_eh_kartongrun = isset($_POST['eh_karton_grun']) ? trim($_POST['eh_karton_grun']) : '';
    $eh_kartgrun_to_save = ($post_eh_kartongrun === '') ? druckrechner_get_raw_preis('eh_karton_grun') : floatval($post_eh_kartongrun);

    $post_eh_karton_gelb = isset($_POST['eh_karton_gelb']) ? trim($_POST['eh_karton_gelb']) : '';
    $eh_karton_gelb_to_save = ($post_eh_karton_gelb === '') ? druckrechner_get_raw_preis('eh_karton_gelb') : floatval($post_eh_karton_gelb);

    $post_eh_karton_weiss = isset($_POST['eh_karton_weiss']) ? trim($_POST['eh_karton_weiss']) : '';
    $eh_karton_weiss_to_save = ($post_eh_karton_weiss === '') ? druckrechner_get_raw_preis('eh_karton_weiss') : floatval($post_eh_karton_weiss);

    $post_eh_karton_grau = isset($_POST['eh_karton_grau']) ? trim($_POST['eh_karton_grau']) : '';
    $eh_karton_grau_to_save = ($post_eh_karton_grau === '') ? druckrechner_get_raw_preis('eh_karton_grau') : floatval($post_eh_karton_grau);

    $post_eh_karton_schwarz = isset($_POST['eh_karton_schwarz']) ? trim($_POST['eh_karton_schwarz']) : '';
    $eh_karton_schwarz_to_save = ($post_eh_karton_schwarz === '') ? druckrechner_get_raw_preis('eh_karton_schwarz') : floatval($post_eh_karton_schwarz);

    // 11. Ringfarbe: -->

    $post_Ringf_schwarz = isset($_POST['ringfarbe_schwarz']) ? trim($_POST['ringfarbe_schwarz']) : '';
    $ringf_schwarz_to_save = ($post_Ringf_schwarz === '') ? druckrechner_get_raw_preis('ringfarbe_schwarz') : floatval($post_Ringf_schwarz);

    $post_Ringf_weiss = isset($_POST['ringfarbe_weiss']) ? trim($_POST['ringfarbe_weiss']) : '';
    $ringf_weiss_to_save = ($post_Ringf_weiss === '') ? druckrechner_get_raw_preis('ringfarbe_weiss') : floatval($post_Ringf_weiss);

    $post_Ringf_blau = isset($_POST['ringfarbe_blau']) ? trim($_POST['ringfarbe_blau']) : '';
    $ringf_blau_to_save = ($post_Ringf_blau === '') ? druckrechner_get_raw_preis('ringfarbe_blau') : floatval($post_Ringf_blau);

    $post_Ringf_rot = isset($_POST['ringfarbe_rot']) ? trim($_POST['ringfarbe_rot']) : '';
    $ringf_rot_to_save = ($post_Ringf_rot === '') ? druckrechner_get_raw_preis('ringfarbe_rot') : floatval($post_Ringf_rot);


        // 12. Kammfarbe: -->

    $post_Kammf_schwarz = isset($_POST['kammfarbe_schwarz']) ? trim($_POST['kammfarbe_schwarz']) : '';
    $kammf_schwarz_to_save = ($post_Kammf_schwarz === '') ? druckrechner_get_raw_preis('kammfarbe_schwarz') : floatval($post_Kammf_schwarz);

    $post_Kammf_weiss = isset($_POST['kammfarbe_weiss']) ? trim($_POST['kammfarbe_weiss']) : '';
    $kammf_weiss_to_save = ($post_Kammf_weiss === '') ? druckrechner_get_raw_preis('kammfarbe_weiss') : floatval($post_Kammf_weiss);

    $post_Kammf_dunkblau = isset($_POST['kammfarbe_dunkelblau']) ? trim($_POST['kammfarbe_dunkelblau']) : '';
    $kammf_dunkblau_to_save = ($post_Kammf_dunkblau === '') ? druckrechner_get_raw_preis('kammfarbe_dunkelblau') : floatval($post_Kammf_dunkblau);

    $post_Kammf_borde = isset($_POST['kammfarbe_bordeaux']) ? trim($_POST['kammfarbe_bordeaux']) : '';
    $kammf_borde_to_save = ($post_Kammf_borde === '') ? druckrechner_get_raw_preis('kammfarbe_bordeaux') : floatval($post_Kammf_borde);


    // 13. Arbeit/Name -->

    $post_Arbeit_name = isset($_POST['arbeit_name']) ? trim($_POST['arbeit_name']) : '';
    $arbeit_name_to_save = ($post_Arbeit_name === '') ? druckrechner_get_raw_preis('Arbeit Name') : floatval($post_Arbeit_name);

    // 15. Fälzelbandfarbe -->

    $post_faelzelb_weiss = isset($_POST['faelzelb_weiss']) ? trim($_POST['faelzelb_weiss']) : '';
    $faelzelb_weiss_to_save = ($post_faelzelb_weiss === '') ? druckrechner_get_raw_preis('faelzelb_weiss') : floatval($post_faelzelb_weiss);

    $post_faelzelb_schwarz = isset($_POST['faelzelb_schwarz']) ? trim($_POST['faelzelb_schwarz']) : '';
    $faelzelb_schwarz_to_save = ($post_faelzelb_schwarz === '') ? druckrechner_get_raw_preis('faelzelb_schwarz') : floatval($post_faelzelb_schwarz);

    $post_faelzelb_dunkelblau = isset($_POST['faelzelb_dunkelblau']) ? trim($_POST['faelzelb_dunkelblau']) : '';
    $faelzelb_dunkelblau_to_save = ($post_faelzelb_dunkelblau === '') ? druckrechner_get_raw_preis('faelzelb_dunkelblau') : floatval($post_faelzelb_dunkelblau);

    $post_faelzelb_rot = isset($_POST['faelzelb_rot']) ? trim($_POST['faelzelb_rot']) : '';
    $faelzelb_rot_to_save = ($post_faelzelb_rot === '') ? druckrechner_get_raw_preis('faelzelb_rot') : floatval($post_faelzelb_rot);


    // 16. CD

    $post_Cd= isset($_POST['cd']) ? trim($_POST['cd']) : '';
    $cd_to_save = ($post_Cd === '') ? druckrechner_get_raw_preis('cd') : floatval($post_Cd);

    $post_Cd_huelle = isset($_POST['cd_huelle']) ? trim($_POST['cd_huelle']) : '';
    $cd_huelle_to_save = ($post_Cd_huelle === '') ? druckrechner_get_raw_preis('cd_huelle') : floatval($post_Cd_huelle);

    $post_Cd_direktdruck = isset($_POST['cd_direktdruck']) ? trim($_POST['cd_direktdruck']) : '';
    $cd_direktdruck_to_save = ($post_Cd_direktdruck === '') ? druckrechner_get_raw_preis('cd_direktdruck') : floatval($post_Cd_direktdruck);

    // 16. Lieferung
    $post_Vers_abh = isset($_POST['versandart_abholung']) ? trim($_POST['versandart_abholung']) : '';
    $vers_abh_to_save = ($post_Vers_abh === '') ? druckrechner_get_raw_preis('versandart_abholung') : floatval($post_Vers_abh);

    $post_Ver_2_werktag= isset($_POST['versandart_1_2_werktage']) ? trim($_POST['versandart_1_2_werktage']) : '';
    $vers_2_werktag_to_save = ($post_Ver_2_werktag === '') ? druckrechner_get_raw_preis('versandart_1_2_werktage') : floatval($post_Ver_2_werktag);

    //16. Zahlungsart:

    $post_Zahlung_nachame = isset($_POST['zahlungsart_nachname']) ? trim($_POST['zahlungsart_nachname']) : '';
    $zahlung_nachname_to_save = ($post_Zahlung_nachame === '') ? druckrechner_get_raw_preis('zahlungsart_nachname') : floatval($post_Zahlung_nachame);


    // 3. DATENBANK SPEICHERN (Upsert-Logik als Closure)

    $upsert = function($name, $price) use ($wpdb, $table) {
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE name = %s", $name
        ));

        if ($exists) {
            $wpdb->update(
                $table,
                ['preis' => $price],
                ['name' => $name],
                ['%f'],
                ['%s']
            );
        } else {
            $wpdb->insert(
                $table,
                ['name' => $name, 'preis' => $price],
                ['%s', '%f']
            );
        }
    };

    $upsert('formatA4', $formatA4_to_save);
    $upsert('formatA5', $formatA5_to_save);
    $upsert('grammatur80', $grammatur80_to_save);
    $upsert('grammatur100', $grammatur100_to_save);
    $upsert('grammatur120', $grammatur120_to_save);
    $upsert('einseitig', $einseitig_to_save);
    $upsert('beidseitig', $beidseitig_to_save);
    $upsert('Seiten', $seiten_to_save);
    $upsert('Farbseiten', $farbseit_to_save);
    //$upsert('Exemplare', $exemplare_to_save);

    // --- Premium Lederoptik ---
$upsert('bindung_premium_lederoptik', $preleder_to_save);
$upsert('einband_premium_lederoptik_bordeaux', $einband_preled_bord_to_save);
$upsert('einband_premium_lederoptik_blau', $einband_preled_blau_to_save);
$upsert('einband_premium_lederoptik_anthrazit', $einband_preled_anthr_to_save);
$upsert('einband_premium_lederoptik_schwarz', $einband_preled_schwa_to_save);

// --- Klemmbuch ---
$upsert('bindung_klemmbuch', $klemmbuch_to_save);
$upsert('einband_klemmbuch_bordeaux', $einband_klemm_bord_to_save);
$upsert('einband_klemmbuch_blau', $einband_klemm_blau_to_save);
$upsert('einband_klemmbuch_grün', $einaband_klemm_grun_to_save);
$upsert('einband_klemmbuch_beige', $einband_klemm_beige_to_save);

// --- Premium Kaschmirleinenoptik ---
$upsert('bindung_premium_kaschmirleinenoptik', $prekaschmir_to_save);
$upsert('einband_premium_kaschmirleinenoptik_blau', $einband_prekasch_blau_to_save);
$upsert('einband_premium_kaschmirleinenoptik_beige', $einband_prekasch_beige_to_save);
$upsert('einband_premium_kaschmirleinenoptik_dunkelgrau', $einband_prekasch_dungrau_to_save);

// --- Простые бинды (без выбора обложки) ---
$upsert('bindung_plastringbindung', $plastring_to_save);
$upsert('bindung_drahtringbindung', $drachtring_to_save);
$upsert('bindung_kammbindung', $kammbind_to_save);
$upsert('bindung_rueckstichheftung', $rueckstich_to_save);

// --- Fälzelband ---
$upsert('bindung_faelzelband', $faelzel_to_save);
$upsert('einband_faelzelband_blau', $einband_faelz_blau_to_save);
$upsert('einband_faelzelband_bordeaux', $einband_faelz_bord_to_save);
$upsert('einband_faelzelband_anthrazit', $einband_faelz_anthr_to_save);
$upsert('einband_faelzelband_schwarz', $einband_faelz_schwa_to_save);
$upsert('einband_faelzelband_grün', $einband_faelz_grun_to_save);

// --- Heißleimbindung ---
$upsert('bindung_heissleimbindung', $heisslei_to_save);
$upsert('einband_heissleimbindung_eigene_geschaltung', $einband_heissl_eingesch_to_save);
$upsert('einband_heissleimbindung_vorne_hinten_blau', $einband_heissl_vohitblau_to_save);
$upsert('einband_heissleimbindung_matte_hinten_blau', $einband_heissl_mathinbla_to_save);
$upsert('einband_heissleimbindung_vorne_hinten_bordeaux', $einband_heissl_vorhinbor_to_save);
$upsert('einband_heissleimbindung_matte_hinten_bordeaux', $einband_heissl_mathinbord_to_save);

    $upsert('bindung_kammbindung', $kammbind_to_save);
    $upsert('bindung_rueckstichheftung', $rueckstich_to_save);

    $upsert('praegung_checkbox', $praegung_to_save);
    $upsert('schriftart_helv', $schifhelv_to_save);
    $upsert('farbe_gold', $farbe_gold_to_save);
    $upsert('farbe_silber', $farbe_silber_to_save);

    $upsert('ev_folie_matt', $ev_folimatt_to_save);
    $upsert('ev_karton_rot', $ev_kartrot_to_save);
    $upsert('ev_karton_bordeaux', $ev_kartbord_to_save);
    $upsert('ev_karton_blau', $ev_kartblau_to_save);
    $upsert('ev_karton_hellblau', $ev_karthellblau_to_save);
    $upsert('ev_karton_olive', $ev_kartolive_to_save);
    $upsert('ev_karton_grun', $ev_kartgrun_to_save);
    $upsert('ev_karton_gelb', $ev_kartgelb_to_save);
    $upsert('ev_karton_weiss', $ev_kartweiss_to_save);
    $upsert('ev_karton_grau', $ev_kartgrau_to_save);
    $upsert('ev_karton_schwarz', $ev_kartschwarz_to_save);

    $upsert('eh_folie_matt', $eh_folimatt_to_save);
    $upsert('eh_karton_rot', $eh_kartrot_to_save);
    $upsert('eh_karton_bordeaux', $eh_kartbord_to_save);
    $upsert('eh_karton_blau', $eh_karton_blau_to_save);
    $upsert('eh_karton_hellblau', $eh_karthellblau_to_save);
    $upsert('eh_karton_olive', $eh_kartolive_to_save);
    $upsert('eh_karton_grun', $eh_kartgrun_to_save);
    $upsert('eh_karton_gelb', $eh_karton_gelb_to_save);
    $upsert('eh_karton_weiss', $eh_karton_weiss_to_save);
    $upsert('eh_karton_grau', $eh_karton_grau_to_save);
    $upsert('eh_karton_schwarz', $eh_karton_schwarz_to_save);

    $upsert('ringfarbe_schwarz', $ringf_schwarz_to_save);
    $upsert('ringfarbe_weiss', $ringf_weiss_to_save);
    $upsert('ringfarbe_blau', $ringf_blau_to_save);
    $upsert('ringfarbe_rot', $ringf_rot_to_save);

    $upsert('kammfarbe_schwarz', $kammf_schwarz_to_save);
    $upsert('kammfarbe_weiss', $kammf_weiss_to_save);
    $upsert('kammfarbe_dunkelblau', $kammf_dunkblau_to_save);
    $upsert('kammfarbe_bordeaux', $kammf_borde_to_save);


    $upsert('Arbeit Name', $arbeit_name_to_save);

     $upsert('faelzelb_weiss', $faelzelb_weiss_to_save);
    $upsert('faelzelb_schwarz', $faelzelb_schwarz_to_save);
    $upsert('faelzelb_dunkelblau',  $faelzelb_dunkelblau_to_save);
    $upsert('faelzelb_rot', $faelzelb_rot_to_save);

    $upsert('cd', $cd_to_save);
    $upsert('cd_huelle', $cd_huelle_to_save);
    $upsert('cd_direktdruck', $cd_direktdruck_to_save);
    
    $upsert('Lieferung: Abholung',  $vers_abh_to_save);
    $upsert('Lieferung: 1-2 Werktage', $vers_2_werktag_to_save);

    $upsert('Zahlungsart: Nachname', $zahlung_nachname_to_save);
    

    // 4. WEITERLEITUNG
    $redirect_url = add_query_arg('druckrechner_saved', '1', wp_get_referer());
    wp_safe_redirect($redirect_url);
    exit;
}

// ---------------------------------------------------------------------
// GLOBALE HILFSFUNKTIONEN (MÜSSEN AUSSERHALB DER HAUPTFUNKTION STEHEN)
// ---------------------------------------------------------------------

/**
 * Ruft den reinen Float-Preis für ein bestimmtes Element ab.
 * @param string $name Z.B. 'Format A4'
 * @return float Der Preis als Dezimalzahl (z.B. 0.03)
 */
function druckrechner_get_raw_preis( $name ) {
    global $wpdb;
    $table = $wpdb->prefix . 'druck_preis';
    
    $preis = $wpdb->get_var( $wpdb->prepare(
        "SELECT preis FROM $table WHERE name = %s",
        $name
    ) );
    
    // Gibt den reinen Float-Wert zurück, standardmäßig 0.0
    return (float) $preis; 
}

/**
 * Ruft den Preis für ein bestimmtes Format aus der Datenbank ab und formatiert ihn.
 * @param string $format_name Z.B. 'Format A5'
 * @return string Der formatierte Preis (z.B. "10,50 €")
 */
function druckrechner_get_aktueller_preis( $format_name ) {
    // Verwendet die Roh-Preis-Funktion für die Berechnung
    $preis = druckrechner_get_raw_preis( $format_name );

    // Preis auf 2 Nachkommastellen formatieren (Deutsch: Komma)
    return number_format( $preis, 2, ',', '.' ) . ' €';
}


// ---------------------------------------------------------------------
// HOOKS
// ---------------------------------------------------------------------

add_action('admin_post_druckrechner_speichern', 'druckrechner_handle_form');