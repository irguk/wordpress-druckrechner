// File: preisrechner.js - KORRIGIERT

// Sicherstellung, dass jQuery im No-Conflict-Modus ($) funktioniert
(function($) {
    
    const ajaxurl = window.ajaxurl; 

    if (typeof ajaxurl === 'undefined') {
        console.error("AJAX Error: 'ajaxurl' ist nicht definiert. Bitte in functions.php prüfen.");
        return;
    }

    function updatePreview() {
        
        // 1. Payload zusammenstellen
        const payload = {
            action: 'druckrechner_ajax',
            format: $('#format').val() || '', 
            grammatur: $('#grammatur').val() || '',
            seitendruck: $('#seitendruck').val() || '',
            seiten: $('#seiten').val() || '0',       
            farbseiten: $('#farbseiten').val() || '0', 
            exemplare: $('#exemplare').val() || '1', 
            bindungsart: $('#bindungsart').val() || '',
            mwst: $('input[name="mwst"]:checked').val() || 'privat', 
            praegung: $('#praegung').is(':checked') ? 'ja' : 'nein', 
            schriftart: $('#schriftart').val() || '',
            ev: $('#ev').val() || '',
            eh: $('#eh').val() || '',
            ringfarbe: $('#ringfarbe').val() || '', 
            faelzelbandfarbe: $('#faelzelbandfarbe').val() || '', 
            kammfarbe: $('#kammfarbe').val() || '', 
            arbeit: $('#arbeit').val() || '',
            farbe: $('#farbe').val() || '',
            cd: $('#cd').val() || '',
            cd_stueck: $('#cd-stueck').val() || '0',
            cd_huelle: $('#cd-huelle').is(':checked') ? 'ja' : 'nein',
            cd_direktdruck: $('#cd-direktdruck').is(':checked') ? 'ja' : 'nein' 
        };
        
        // 2. AJAX-POST-Request
        $.post(ajaxurl, payload)
            .done(function(response) {
                // Bei Erfolg: Preise aktualisieren
                // NEU: Entfernen des doppelten ' + ' €', da PHP den Wert bereits formatiert
                $('#einzelpreis').text(response.einzelpreis);  
                $('#gesamtpreis').text(response.bruttopreis); // Zeigt den Bruttopreis (Endpreis)
                
                // Vorschau aktualisieren (IDs in der Vorschau müssen existieren!)
                $('#vorschau-seitendruck').text(response.seitendruck || '–');
                $('#vorschau-seiten').text(response.seiten + ', davon ' + response.farbseiten + ' farbig');
                $('#vorschau-format').text(response.format || '–');
                $('#vorschau-grammatur').text(response.grammatur || '–');

                // 1. Sichtbarkeit des CD-Blocks steuern
                if (response.cd === 'ja' && parseInt(response.cd_stueck) > 0) {
                    // Wenn CD gewählt ist und Stückzahl > 0: Block anzeigen
                    $('#cd-details').show();
                } else {
                    // Andernfalls: Block verstecken
                    $('#cd-details').hide();
                }

                // 2. Einzelne Werte direkt in die Spans einfügen (basierend auf HTML-IDs)
                $('#preview-cd-stueck').text(response.cd_stueck);
                $('#preview-cd-huelle').text(response.cd_huelle); // Füllt mit 'Ja' oder 'Nein' aus PHP-Antwort
                $('#preview-cd-direktdruck').text(response.cd_direktdruck === 'ja' ? 'Ja' : 'Nein');

                // NEU: Aktualisierung der Bindungsvorschau
                $('#vorschau-bindung-name').text(response.bindung || 'Ihre Bindung:');
                $('#vorschau-bindung-beschreibung').text(response.bindungsartBeschreibung || '');
                $('#vorschau-bindung-bild').attr('src', response.bindungsartBildUrl || '');
                // Optional: Fehlerbilder vermeiden, falls URL leer ist
                // if (response.bindungsartBildUrl === '') { $('#vorschau-bindung-bild').hide(); } else { $('#vorschau-bindung-bild').show(); }
                // NEUE VORSCHAU-ELEMENTE AKTUALISIEREN
        
                const beschreibung = response.bindungsbeschreibung || 'Keine weitere Beschreibung verfügbar.';
                
                // Hier benötigen Sie IDs in Ihrem HTML für die Ausgabe der Beschreibung und des Bildes.
                $('#vorschau-bindung-beschreibung').text(beschreibung); 
                
                // Wenn Sie ein Bild haben:
                if (response.bindungsbildurl) {
                    $('#vorschau-bindung-bild').attr('src', response.bindungsbildurl).show();
                } else {
                    $('#vorschau-bindung-bild').hide();
                }
            })
            .fail(function(xhr) {
                // Bei Fehler
                console.error('AJAX FAIL:', xhr.responseText || 'HTTP Status ' + xhr.status);
                $('#einzelpreis').text('Fehler!');
                $('#gesamtpreis').text('Fehler!');
            });
    }
    
    // 3. Initialer Aufruf und Event-Handler registrieren
    $(document).ready(function() {
        updatePreview();
      // 4. Sichtbarkeit der Prägungs-Details steuern
    function handlePraegungToggle() {
        if ($('#praegung').is(':checked')) {
            // Wenn Prägung gewählt, den Detail-Block anzeigen
            $('#praegung-details').slideDown(); 
        } else {
            // Andernfalls: Block verstecken und Felder zurücksetzen (optional, aber empfohlen)
            $('#praegung-details').slideUp(); 
            // Optional: Setzen Sie die Werte in den Feldern auf den Standardwert zurück
            $('#schriftart').val('');
           
        }
        // Führt immer auch die Preisberechnung aus
        updatePreview(); 
    }
    
    // 5. Listener für die Prägung-Sichtbarkeit registrieren
    $('#praegung').on('change', handlePraegungToggle);
    
    // 6. Initialen Zustand der Prägung prüfen (damit der Block beim Laden korrekt versteckt/angezeigt wird)
    handlePraegungToggle();
      
      // Keyup/Change-Events registrieren
$('#format, #grammatur, #seitendruck, #seiten, #farbseiten, #exemplare, #bindungsart, input[name="mwst"]').on('change keyup', updatePreview);

// РЕГИСТРАЦИЯ НОВЫХ ПОЛЕЙ
$('#praegung, #schriftart, #ev, #eh, #ringfarbe, #faelzelbandfarbe, #kammfarbe, #arbeit, #farbe, #cd, #cd-stueck, #cd-huelle, #cd-direktdruck').on('change keyup', updatePreview);
 });   
})(jQuery);  