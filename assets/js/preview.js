// ==========================================================
// GLOBALE HILFSFUNKTIONEN UND KONSTANTEN
// ==========================================================

// Konfiguration für die dynamischen Einband-Optionen
const filterEinband = {
  'premium_lederoptik': [ 'bordeaux', 'blau', 'anthrazit', 'schwarz'],
   'klemmbuch': ['bordeaux', 'blau', 'grün', 'beige', ],
   'premium_kaschmirleinenoptik': ['blau', 'beige', 'dunkelgrau'],
   'hardcover': ['blau', 'bordeaux', 'anthrazit', 'schwarz', 'grün'],
   'softcover': ['blau', 'bordeaux', 'anthrazit', 'schwarz', 'grün'],
   'faelzelband': ['blau', 'bordeaux', 'anthrazit', 'schwarz', 'grün'],
   'heissleimbindung': [
   'eigene_geschaltung',
    'vorne_hinten_blau',
    'matte_hinten_blau',
    'vorne_hinten_bordeaux',
    'matte_hinten_bordeaux'
  ],
};  

function cleanKey(key) {
    if (!key) return '';
    let str = key.toLowerCase();
    str = str.replace(/ /g, '_')
             .replace(/[äöüß]/g, (m) => ({ 'ä': 'ae', 'ö': 'oe', 'ü': 'ue', 'ß': 'ss' })[m])
             .replace(/[^a-z0-9_]/g, '');
    return str;
}

function updateBindungsBeschreibung(bindungsartKey) {
    const erklaerungElement = document.getElementById('bindung-erklärung');
    
    // Texte für Bindungsbeschreibungen (jetzt als HTML-Arrays)
    const beschreibungenHTML = {
      'ohne_bindung': ["Druck ohne Bindung"],
      
      'hardcover': [
        "Stabiles, hochwertiges Hardcover-Buch.", 
        "Prägung möglich."
      ],
      
      'premium_lederoptik': [
        "In A4 erhältlich.", 
        "Oberfläche in Lederoptik.", 
        "Hohe Stabilität.", 
        "Prägung möglich."
      ],
      
      'klemmbuch': [
        "Praktische Klemmmechanik für einfache Handhabung."
      ],
      
      'premium_kaschmirleinenoptik': [
        "In A4 erhältlich.", 
        "Premium Leinenoptik, strukturierte Oberfläche.", 
        "Stabiles, preiswertes Hardcoverbuch."
      ],
      
      'softcover': [
        "Flexibler, leichter Einband.", 
        "Prägung möglich."
      ],
      
      'plastringbindung': [
        "Preiswerte und flexible Bindung mit Kunststoffring."
      ],
      
      'drahtringbindung': [
        "Robuste und elegante Bindung mit Metallring."
      ],
      
      'faelzelband': [
        "Bindung mit einem Fälzelband zur Verstärkung des Rückens."
      ],
      
      'heissleimbindung': [
        "Klassische Heißleimbindung für dauerhafte Haltbarkeit."
      ],
      
      'kammbindung': [
        "Einfache und kostengünstige Kammbindung."
      ],
      
      'rueckstichheftung': [
        "Einfache Heftung für dünne Broschüren."
      ]
    };

    if (erklaerungElement) {
        const beschreibungsArray = beschreibungenHTML[bindungsartKey];
        
        let htmlContent = '';

        if (beschreibungsArray && beschreibungsArray.length > 0) {
            // Generieren der strukturierten Liste mit Häkchen-Symbolen (HTML-Entity &#x2714;)
            // und einem <p>-Tag, um die Struktur zu behalten.
            
            // Verwenden Sie <p> für jeden Eintrag, oder eine ungeordnete Liste <ul>
            htmlContent = beschreibungsArray.map(punkt => 
                `<p class="binding-feature">
                    <span class="checkmark">&#x2714;</span> ${punkt}
                </p>`
            ).join('');

        } else {
            htmlContent = '<p>Keine weitere Beschreibung verfügbar.</p>';
        }

        // Setzen des Inhalts als HTML
        erklaerungElement.innerHTML = htmlContent;
    }
}

/**
 * Funktion zur Aktualisierung des kleinen Bindungsbildes
 */
function updateBindungsBild(bindungsartKey) {
    const bindungImg = document.getElementById('preview-bindung-img');
    const bildPfadBasis = '/wp-content/plugins/druckrechner/templates/img/';
    const ohneBindungSrc = bildPfadBasis + 'ohne.jpg';
    const cacheBuster = Date.now();

    const cleanedKey = cleanKey(bindungsartKey);

    if (bindungImg) {
        let bildPfadBindung;

        if (!bindungsartKey || cleanedKey === 'ohne_bindung') {
            bildPfadBindung = ohneBindungSrc;
        } else {
            // Generische Platzhalter-Grafik für fehlende spezifische Bilder verwenden
            bildPfadBindung = `${bildPfadBasis}${cleanedKey}/binding_preview.png?cache=${cacheBuster}`;
        }

        bindungImg.src = bildPfadBindung;

        bindungImg.onerror = () => {
             bindungImg.src = ohneBindungSrc;
        };
    }
}

/**
 * Hilfsfunktion, um lange 'value' Attribute in lesbaren Text umzuwandeln.
 */
function getEinbandDisplayText(value) {
    switch (value) {
        case 'eigene_geschaltung':
            return 'eigene Gestaltung/individuelle Gestaltung';
        case 'vorne_hinten_blau':
            return 'vorne und hinten blau';
        case 'vorne_hinten_bordeaux':
            return 'vorne und hinten bordeaux';
        case 'matte_hinten_blau':
            return 'matte Folie vorne und hinten blau';
        case 'matte_hinten_bordeaux':
            return 'matte Folie vorne und hinten bordeaux';
        default:
            return value.charAt(0).toUpperCase() + value.slice(1);
    }
}

/**
 * Filtert die Bindungsarten basierend auf dem Format und behält den Wert bei.
 */
function updateBindingOptions() {
    const formatSelect = document.getElementById('format');
    const bindingSelect = document.getElementById('bindungsart');
    const selectedFormat = formatSelect?.value;

    if (!bindingSelect || !formatSelect) return;

    const currentValue = bindingSelect.value;
    let currentValueStillValid = false;

    bindingSelect.disabled = !selectedFormat;

    const allOptions = bindingSelect.querySelectorAll('option:not([value=""])');
    const hardcoverGroup = document.getElementById('hardcover-group');
    const softcoverGroup = document.getElementById('softcover-group');

    let hardcoverVisible = false;
    let softcoverVisible = false;

    allOptions.forEach(option => {
        const availableFormats = option.getAttribute('data-formats');

        if (selectedFormat && (!availableFormats || availableFormats.includes(selectedFormat))) {
            option.style.display = '';
            if (option.closest('optgroup') === hardcoverGroup) {
                hardcoverVisible = true;
            } else if (option.closest('optgroup') === softcoverGroup) {
                softcoverVisible = true;
            }
            if (option.value === currentValue) {
                currentValueStillValid = true;
            }
        } else {
            option.style.display = 'none';
        }
    });

    if (hardcoverGroup) hardcoverGroup.style.display = hardcoverVisible ? '' : 'none';
    if (softcoverGroup) softcoverGroup.style.display = softcoverVisible ? '' : 'none';

    // Setzt den Wert zurück, wenn kein Format gewählt oder der aktuelle Wert ungültig ist
    if (!selectedFormat || (currentValue && !currentValueStillValid)) {
         bindingSelect.value = "";
    }
}

/**
 * Lädt die Einband-Optionen und steuert deren Sichtbarkeit.
 */
function updateEinbandOptions() {
    const bindungsartRaw = document.getElementById("bindungsart")?.value;
    // Wichtig: Key aus dem value-Attribut des Select-Feldes generieren
    const bindungsartKey = cleanKey(bindungsartRaw);

    const einbandSelect = document.getElementById("einband");
    const einbandBlock = document.getElementById('einband-block');

    if (!einbandSelect) return;

    const currentValue = einbandSelect.value;
    let isCurrentValueAvailable = false;

    einbandSelect.innerHTML = '<option value="" disabled selected>Bitte wählen</option>';

    const availableOptions = filterEinband[bindungsartKey] || [];

    if (availableOptions.length > 0) {

        availableOptions.forEach(optionValue => {
            const option = document.createElement("option");
            option.value = optionValue;
            option.textContent = getEinbandDisplayText(optionValue);
            einbandSelect.appendChild(option);

            if (optionValue === currentValue) {
                isCurrentValueAvailable = true;
            }
        });

        if (currentValue && isCurrentValueAvailable) {
            einbandSelect.value = currentValue;
        } else {
            // Wählt die erste Option als Standard (oder leeren Wert)
            einbandSelect.value = availableOptions.length > 0 ? availableOptions[0] : "";
        }

        if (einbandBlock) {
             einbandBlock.style.display = 'block';
        }
    } else {
        if (einbandBlock) {
            einbandBlock.style.display = 'none';
        }
    }
}

/**
 * Hauptfunktion für alle Aktualisierungen (MUSS GLOBAL SEIN, um von Inline-Events und Add-Listeners erreicht zu werden).
 */
function updatePreview() {
    // --- WERTE ZUERST ABRUFEN ---
    const bindungsartSelect = document.getElementById('bindungsart');
    const bindungsartValue = bindungsartSelect?.value || '';
    const bindungsartText = bindungsartSelect?.options[bindungsartSelect.selectedIndex]?.text || 'ohne Bindung';
    // Der Key für Logik/Bilder wird aus dem Text/Value generiert
    const bindungsartKey = cleanKey(bindungsartValue);

    // 💡 Wichtig: Die Filterung muss zuerst laufen, um die korrekten Werte zu setzen
    updateBindingOptions();
    updateEinbandOptions();

    // --- WEITERE WERTE ABRUFEN ---
    const einband = document.getElementById('einband')?.value || '';
    const format = document.getElementById('format')?.value || '';
    const praegungCheckbox = document.getElementById('praegung');
    // Die Variable 'bild' in updatePreview umbenennen, um den SyntaxError zu beheben (z.B. in 'previewBild')
    const previewBild = document.getElementById('previewimg');
    const lupe = document.getElementById('zoom-lupe');

    // KORREKTE CD-ID-ABRUFE
    const cdCheckbox = document.getElementById('cd');
    const cdHuelleCheckbox = document.getElementById('cd-huelle');
    const cdDirektdruckCheckbox = document.getElementById('cd-direktdruck');

    // Den Zustand der Checkboxen als string 'ja'/'nein' abrufen
    const cdChecked = cdCheckbox?.checked ? 'ja' : 'nein';
    const cdHuelleChecked = cdHuelleCheckbox?.checked ? 'ja' : 'nein';
    const cdDirektdruckChecked = cdDirektdruckCheckbox?.checked ? 'ja' : 'nein';

    const praegungChecked = praegungCheckbox?.checked ? 'ja' : 'nein';

    // Die Stückzahl der CDs abrufen
    const cdStueck = document.getElementById('cd-stueck')?.value || '1';

    // --- BINDUNGS-DETAILS AKTUALISIEREN ---
    updateBindungsBeschreibung(bindungsartKey);
    updateBindungsBild(bindungsartKey);

    const previewBindungElement = document.getElementById('preview-bindung');
    if (previewBindungElement) {
        previewBindungElement.textContent = bindungsartText;
    }
    
// 2. Werte abrufen
    
    const grammatur = document.getElementById('grammatur')?.value || '-';
    const seiten = document.getElementById('seiten')?.value || '0';
   

    // 3. Druck-Angebot (printable-offer) befüllen
    if (document.getElementById('print-format')) document.getElementById('print-format').innerText = format;
    if (document.getElementById('print-grammatur')) document.getElementById('print-grammatur').innerText = grammatur;
    if (document.getElementById('print-seiten')) document.getElementById('print-seiten').innerText = seiten;
    if (document.getElementById('print-bindung')) document.getElementById('print-bindung').innerText = bindungsartText;


    // 🔄 Vorschau aktualisieren (AJAX)
    const data = {
        action: 'druckrechner_ajax',
        format: document.getElementById('format')?.value || '',
        grammatur: document.getElementById('grammatur')?.value || '',
        seitendruck: document.getElementById('seitendruck')?.value || '',
        seiten: document.getElementById('seiten')?.value || '',
        farbseiten: document.getElementById('farbseiten')?.value || '',
        exemplare: document.getElementById('anzahl_exemplare')?.value || '',

        bindungsart: bindungsartValue, // Wichtig: den Value verwenden
        einband: einband,

        ev: document.getElementById('ev')?.value || '',
        eh: document.getElementById('eh')?.value || '',
        ringfarbe: document.getElementById('ringfarbe')?.value || '',
        farbe: document.getElementById('farbe')?.value || '',
        faelzelbandfarbe: document.getElementById('faelzelbandfarbe')?.value || '',
        kammfarbe: document.getElementById('kammfarbe')?.value || '',

        cd: cdChecked,
        cd_stueck: cdStueck,
        cd_huelle: cdHuelleChecked,
        cd_direktdruck: cdDirektdruckChecked,

        praegung: praegungChecked,
        schriftart: document.getElementById('schriftart')?.value || '',

        mwst: document.querySelector('input[name="mwst"]:checked')?.value || 'privat',
        zahlungsart: document.getElementById('zahlungsart')?.value || 'vorkasse_per_ueberweisung'
    };

    // Stelle sicher, dass "ajaxurl" durch wp_localize_script im Backend verfügbar ist!
    if (typeof ajaxurl !== 'undefined' && ajaxurl.url) {
        fetch(ajaxurl.url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data)
        })
        .then(response => {
             if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
             }
             return response.json();
        })
        .then(data => {
            // Aktualisiere alle Preis- und Detailfelder
            document.getElementById('preview-format').textContent = data.format || '–';
            document.getElementById('preview-grammatur').textContent = data.grammatur || '–';
            document.getElementById('preview-seiten').textContent = data.seiten || '–';
            document.getElementById('preview-farbseiten').textContent = data.farbseiten || '–';
            document.getElementById('preview-seitendruck').textContent = data.seitendruck || '–';
            
            document.getElementById('preview-exemplare').textContent = `${data.exemplare || '–'} Exemplare`;
            document.getElementById('preview-einzelpreis').textContent = `${data.einzelpreis || '0,00'} €`;
            document.getElementById('preview-gesamtpreis').textContent = `${data.bruttopreis || '0,00'} €`;

            
            // CD-Details
            const cdDetailsBlock = document.getElementById('cd-details');
            const cdIsSelected = data.cd === 'ja';

            if (cdDetailsBlock) {
                cdDetailsBlock.style.display = cdIsSelected ? 'block' : 'none';
                if (cdIsSelected) {
                    document.getElementById('preview-cd-stueck').textContent = data.cd_stueck || '1';
                    document.getElementById('preview-cd-huelle').textContent = data.cd_huelle === 'ja' ? 'Ja' : 'Nein';
                    document.getElementById('preview-cd-direktdruck').textContent = data.cd_direktdruck === 'ja' ? 'Ja' : 'Nein';
                }
            }
        })
        .catch(error => {
            console.error('Fehler bei Vorschau (AJAX):', error);
            document.getElementById('preview-gesamtpreis').textContent = `Fehler!`;
            document.getElementById('preview-einzelpreis').textContent = `Fehler!`;
        });
    }


    // 🔄 Hauptbild aktualisieren (MIT CACHE-BUSTER)
    if (previewBild) {
        let bildPfad = '/wp-content/plugins/druckrechner/templates/previewimg.php';
        const cacheBuster = Date.now();
        const bindungsart = document.getElementById('bindungsart')?.value || '';

        if (bindungsart) {
            let params = new URLSearchParams();
            params.append('bind', bindungsart);
            params.append('format', format);

            if (einband) {
                params.append('einband', einband);
            }

            params.append('cache', cacheBuster);

            previewBild.src = `${bildPfad}?${params.toString()}`;
            previewBild.style.display = "block";

            previewBild.onerror = () => {
              previewBild.src = "/wp-content/plugins/druckrechner/templates/img/previewimg.png";
            };

        } else {
          previewBild.src = "/wp-content/plugins/druckrechner/templates/img/previewimg.png";
          previewBild.style.display = "block";
        }
    }

    // Aktualisiere den Zoom-Hintergrund, falls vorhanden
    if (previewBild && lupe) {

        previewBild.onload = function() {
             const zoomFactor = 2.5;
             lupe.style.backgroundImage = `url(${previewBild.src})`;
             lupe.style.backgroundSize =
                `${previewBild.offsetWidth * zoomFactor}px ${previewBild.offsetHeight * zoomFactor}px`;
        };

        if (previewBild.complete) {
            previewBild.onload();
        }
    }

    // 🔍 Lupe anzeigen
    const bindung = cleanKey(bindungsartValue);
    if (lupe) {
        if (praegungCheckbox?.checked && ['premium_lederoptik', 'hardcover', 'softcover'].includes(bindung)) {
          lupe.style.display = 'block';
        } else {
          lupe.style.display = 'none';
        }
    }

} // <--- ENDE DER GLOBALEN updatePreview() FUNKTION


function updateVersandkosten() {
    const selectElement = document.getElementById('versandart');
    const versandkostenOutput = document.querySelector('.versandkosten p');
    const selectedValue = selectElement?.value;
    let kostenText = '';

    if (selectedValue === 'abholung') {
        kostenText = 'zzgl. 0,00€ Versandkosten';
    } else if (selectedValue === '1-2_werktage') {
        kostenText = 'zzgl. 9,49€ Versandkosten';
    } else {
        kostenText = 'Versandkosten werden berechnet...';
    }
    if (versandkostenOutput) versandkostenOutput.textContent = kostenText;
}

/**
 * Steuert die Anzeige der Nachnahme-Kosten.
 */
function updateNachnahmeKosten() {
    const selectElement = document.getElementById('zahlungsart');
    const nachnahmeKostenOutput = document.getElementById('nachnahmeKostenOutput');
    const selectedValue = selectElement?.value;
    let kostenText = '';

    if (selectedValue === 'nachname') {
        kostenText = 'zzgl. 7,00€ Nachnahme';
    } else {
        kostenText = 'zzgl. 0,00€ Nachnahme';
    }

    if (nachnahmeKostenOutput) {
        nachnahmeKostenOutput.textContent = kostenText;
    }
}


// ==========================================================
// DOM-INITIALISIERUNG UND EVENT-LISTENER
// ==========================================================
document.addEventListener('DOMContentLoaded', function () {
    // 🔧 Blockelemente definieren
    const blocks = {
        einband: document.getElementById('einband-block'),
        einband_h: document.getElementById('einband-h-block'),
        schriftart: document.getElementById('schriftart-block'),
        farbe: document.getElementById('farbe-block'),
        ev: document.getElementById('ev_block'),
        eh: document.getElementById('eh_block'),
        ringfarbe: document.getElementById('ringfarbe-block'),
        faelzelbandfarbe: document.getElementById('faelzelbandfarbe-block'),
        kammfarbe: document.getElementById('kammfarbe-block'),
        arbeitName: document.getElementById('arbeits-name-block'),
        praegung: document.getElementById('praegung-block'),
        //cdBox: document.getElementById('cd-box'),
        cd: document.getElementById('cd-block'),
        cdStueck: document.getElementById('cd-stueck-block'),
        cdHuelle: document.getElementById('cd-huelle-block'),
        cdDruck: document.getElementById('cd-direktdruck-block')
    };

    function hideAllBlocks() {
        Object.values(blocks).forEach(el => {
            if (el) el.style.display = 'none';
        });
    }

    function showBlocks(keys) {
        keys.forEach(key => {
            const el = blocks[key];
            if (el) el.style.display = 'block';
        });
    }

    // Bindungs-Mapping
    const bindungsMapping = {
      'ohne_bindung': ['einband',  'cd'],
      'hardcover': ['einband','praegung', 'schriftart', 'farbe', 'ev', 'eh', 'cd'],
      'premium_lederoptik': ['einband', 'praegung', 'schriftart','farbe', 'cd'],
      'klemmbuch': ['einband', 'praegung', 'schriftart', 'ev', 'eh',  'cd'],
      'premium_kaschmirleinenoptik': ['einband', 'praegung', 'schriftart', 'farbe', 'ev', 'eh', 'cd'],
      'softcover': ['einband', 'praegung', 'schriftart', 'farbe', 'ev', 'eh', 'cd'],
      'plastringbindung': ['ev', 'eh', 'ringfarbe', 'cd'],
      'drahtringbindung': ['ev', 'eh', 'ringfarbe',  'cd'],
      'faelzelband': ['einband', 'ev', 'eh', 'faelzelbandfarbe',  'cd'],
      'heissleimbindung': ['einband',  'cd'],
      'kammbindung': ['kammfarbe', 'cd'],
      'rueckstichheftung': ['ev', 'eh', 'cd']
    };

    const praegungCheckbox = document.getElementById('praegung');
    const cdCheckbox = document.getElementById('cd');

    const praegungExtraFields = ['schriftart', 'farbe', 'arbeitName'];
    const cdExtraFields = ['cdStueck', 'cdHuelle', 'cdDruck'];

    // Steuerung der CD-Zusatzfelder
    function handleCdChange() {
        if (!cdCheckbox) return;

        if (cdCheckbox.checked) {
            showBlocks(cdExtraFields);
        } else {
            cdExtraFields.forEach(key => {
                const el = blocks[key];
                if (el) el.style.display = 'none';
            });
        }
        updatePreview();
    }

    // Funktion zur Steuerung der Prägungsfelder
    function handlePraegungChange(bindung) {
const praegungCheckbox = document.getElementById('praegung');
        
        // Список видов переплета, где разрешена тиснение (Prägung)
        const allowedBindings = ['premium_lederoptik', 'hardcover', 'softcover', 'klemmbuch', 'premium_kaschmirleinenoptik'];

        if (praegungCheckbox && allowedBindings.includes(bindung)) {
            if (praegungCheckbox.checked) {
                showBlocks(praegungExtraFields);
            } else {
                // Скрываем поля, если галочка снята
                praegungExtraFields.forEach(key => {
                    const el = blocks[key];
                    if (el) el.style.display = 'none';
                });
            }
        }
        updatePreview();
    }

        // if (praegungCheckbox && ['premium_lederoptik', 'hardcover', 'softcover'].includes(bindung)) {

            // if (praegungCheckbox.checked) {
            //     showBlocks(praegungExtraFields);
            // } else {
            //     praegungExtraFields.forEach(key => {
             //        const el = blocks[key];
  //                   if (el) el.style.display = 'none';
  //               });
  //           }
         // praegungExtraFields.forEach(key => {
     //            const el = blocks[key];
   //              if (el) el.style.display = 'none';
  //           });
 //        }
         // Der Listener auf die Checkbox selbst wird unten initialisiert
        // updatePreview();
   // }


    // ZENTRALISIERTER BLOCK-STEUERUNGS-LISTENER auf Bindungsart
    document.getElementById('bindungsart')?.addEventListener('change', function() {
        const bindungsartRaw = this.value;
        const bindung = cleanKey(bindungsartRaw);

        // 1. Alle Blöcke ausblenden
        hideAllBlocks();

        // 2. Erforderliche Blöcke für Bindung anzeigen
        const selectedBlocks = bindungsMapping[bindung];
        if (selectedBlocks) {
          showBlocks(selectedBlocks);
        }

        // 3. Prägung-Zusatzfelder steuern
        handlePraegungChange(bindung);

        // 4. CD-Zusatzfelder steuern (Initialisierung nach Bindungsart-Wechsel)
        if (blocks.cdBox && blocks.cdBox.style.display === 'block') {
            handleCdChange();
        }

        // 5. Update Preview wird in handleCdChange/handlePraegungChange aufgerufen oder direkt
        updatePreview();
    });

    // Listener für die CD-Checkbox
    if (cdCheckbox) {
        cdCheckbox.addEventListener('change', handleCdChange);
    }

    // Listener für die Prägungs-Checkbox (ausgelagert, da es keine Bindungsart-Abhängigkeit mehr hat)
    if (praegungCheckbox) {
        praegungCheckbox.addEventListener('change', function() {
            // Holen der aktuellen Bindung für die Logik in handlePraegungChange
            const bindungsartRaw = document.getElementById('bindungsart')?.value;
            const bindung = cleanKey(bindungsartRaw);
            handlePraegungChange(bindung);
        });
    }

    // Listener für Bindungsanzeige (unter dem Select-Feld)
    document.getElementById('bindungsart')?.addEventListener('change', function() {
        const display = document.getElementById('selected-binding');
        const selectedText = this.options[this.selectedIndex]?.text;
        if (display && selectedText) {
            display.textContent = selectedText === '-----' ? '---' : selectedText;
        }
    });

    // 🔁 Event Listener für alle Felder, die updatePreview auslösen sollen
    const feldIds = [
      'format', 'grammatur', 'seitendruck', 'seiten', 'farbseiten',
      'anzahl_exemplare', 'einband', 'cd-huelle', 'cd-direktdruck', 'cd-stueck',
      'ev', 'eh', 'farbe', 'ringfarbe', 'kammfarbe'
    ];

    // 🔁 Initialer Aufruf
    // Fügen Sie DIESE ZEILE HINZU, um den Wert VOR dem ersten Aufruf zu setzen
    const anzahlExemplareInput = document.getElementById('anzahl_exemplare');
    if (anzahlExemplareInput && !anzahlExemplareInput.value) {
        anzahlExemplareInput.value = '1';
    }

    feldIds.forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        // 'input' für schnelle Eingaben, 'change' für Selects und Checkboxen
        el.addEventListener('change', updatePreview);
        el.addEventListener('input', updatePreview);
      }
    });

    // MwSt. Radio-Buttons
    document.querySelectorAll('input[name="mwst"]').forEach(radio => {
      radio.addEventListener('change', updatePreview);
    });

    // Initialisierung der Versandkosten
    const versandartSelect = document.getElementById('versandart');
    if (versandartSelect) {
        versandartSelect.addEventListener('change', updateVersandkosten);
    }
    updateVersandkosten();

    // Initialisierung und Listener für Zahlungsart (Nachnahme & Preview)
    const zahlungsartSelect = document.getElementById('zahlungsart');
    if (zahlungsartSelect) {
        zahlungsartSelect.addEventListener('change', updateNachnahmeKosten);
        zahlungsartSelect.addEventListener('change', updatePreview);
    }
    updateNachnahmeKosten();

    // --- ZUMLOGIK --- (Originalcode beibehalten)
    const bildContainer = document.getElementById('bildContainer');
    const previewImg = document.getElementById('previewimg');
    const zoomLupe = document.getElementById('zoom-lupe');

    if (bildContainer && previewImg && zoomLupe) {
        const zoomFactor = 2.5;

        previewImg.onload = function() {
            zoomLupe.style.backgroundImage = `url(${previewImg.src})`;
            zoomLupe.style.backgroundSize =
                `${previewImg.offsetWidth * zoomFactor}px ${previewImg.offsetHeight * zoomFactor}px`;
        }

        // Mouse-Events nur hinzufügen, wenn die Lupe angezeigt werden soll (spart Performance)
        bildContainer.addEventListener('mousemove', (e) => {
             // Nur fortfahren, wenn Lupe sichtbar (wird in updatePreview() gesteuert)
            if (window.getComputedStyle(zoomLupe).display === 'block') {
                const rect = bildContainer.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                zoomLupe.style.left = `${x}px`;
                zoomLupe.style.top = `${y}px`;

                const bgPosX = -(x * zoomFactor - (zoomLupe.offsetWidth / 2));
                const bgPosY = -(y * zoomFactor - (zoomLupe.offsetHeight / 2));

                zoomLupe.style.backgroundPosition = `${bgPosX}px ${bgPosY}px`;
            }
        });

        // Toggle Lupe mit Mousenter/Mouseleave (wird in updatePreview() überschrieben, aber gut als Fallback)
        bildContainer.addEventListener('mouseenter', () => {
             if (window.getComputedStyle(zoomLupe).display === 'none') {
                zoomLupe.style.display = 'block';
             }
        });

        bildContainer.addEventListener('mouseleave', () => {
            zoomLupe.style.display = 'none';
        });
    }

    // 🔁 Initialer Aufruf
    updatePreview();
});