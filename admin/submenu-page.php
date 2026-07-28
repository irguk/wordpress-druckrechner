<?php
defined('ABSPATH') || exit;


if (isset($_GET['success']) && $_GET['success'] == '1') : ?>
    <div class="notice notice-success" style="padding: 15px; background-color: #dff0d8; border-left: 4px solid #3c763d; margin-bottom: 20px;">
        <p><strong>✅ Preise wurden erfolgreich gespeichert!</strong></p>
    </div>
    <script>
        setTimeout(function() {
    jQuery('#success-message').fadeOut();
}, 4000);

    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == '1') : ?>
    <div class="notice notice-error" style="padding: 15px; background-color: #f2dede; border-left: 4px solid #a94442; margin-bottom: 20px;">
        <p><strong>⚠️ Fehler beim Speichern!</strong></p>
    </div>
<?php endif; ?>

<style>
/* * CSS-Anpassungen für linke Ausrichtung und responsive horizontale Darstellung
 * -------------------------------------------------------------------------
 */

/* Container für horizontale Gruppen (Format, Grammatur, Seitendruck) */
.format-section {
    display: flex;
    align-items: flex-start;
    /* WICHTIG: Strikte linke Ausrichtung */
    justify-content: flex-start;
    gap: 40px; /* Abstand zwischen den Gruppen (z.B. A5 und A4) */
    padding-bottom: 10px;
    /* Zeilenumbruch für mobile Geräte */
    flex-wrap: wrap; 
}

/* Jeder individuelle Format-Block (A5, A4, 80g etc.) */
.format-group {
    display: flex;
    align-items: center;
    gap: 10px;
    /* Verhindert, dass die Gruppe wächst oder schrumpft und hält sie links */
    flex: 0 0 auto; 
    min-width: auto;
    padding-right: 20px; /* Platz, damit die Elemente beim Umbruch nicht kleben */
}

/* Trennlinie über die gesamte Breite */
.full-width-separator {
    border: none;
    border-top: 1px solid #ccc;
    margin: 15px 0; 
}

/* Stil für das Eingabefeld (Standard) */
.format-section input[type="number"], .format-row input[type="number"] {
    width: 80px; 
    text-align: right;
}

/* Genereller Stil für die Preiswerte */
.actual-price-value, 
.neue-price-label {
    font-weight: bold;
}

/* -------------------------------------------------------------------------
 * NEU: CSS für das 3-Spalten-Gitter (Bindung)
 * -------------------------------------------------------------------------
 */
.binding-grid {
    display: grid;
    /* Stellt sicher, dass auf großen Bildschirmen 3 gleichmäßige Spalten verwendet werden.
       Auf kleineren Bildschirmen bricht es automatisch auf 2 oder 1 Spalte um,
       da minmax(300px, 1fr) die Spaltenbreite begrenzt. */
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
    gap: 20px 30px; /* Vertikaler und horizontaler Abstand */
    padding-bottom: 10px;
}

.binding-item {
    /* Entfernt die unnötige untere Linie hier, da es in 3 Spalten angeordnet ist */
    display: flex;
    align-items: right;
    gap: 8px; /* Kleiner Abstand zwischen den Labels */
    padding: 0; /* Kein Padding, da das Grid den Abstand regelt */
}

/* Schiebt das Eingabefeld ganz nach rechts im 'binding-item' */
.binding-item input[type="number"] {
    margin-right: auto; /* Pushed das Element nach rechts */
    flex-shrink: 0;
}
</style>
    <form class="form-inline" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <!-- Deine Formularfelder hier -->
         <input type="hidden" name="action" value="druckrechner_speichern">
         <?php wp_nonce_field('druckrechner_form_action', 'druckrechner_nonce'); ?>
            <div class="druck-form" id="druckForm">
                
                <!-- 1. Format (A5 und A4 in einer Linie) -->
                <div>
                      <h4 >1. Format</h4>
                    <div class="format-section">
  
                        <div class="format-group">
                            <!-- A5 Gruppe -->
                            <label for="formatA5">Format A5</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_formatA5">
                                <?php echo druckrechner_get_aktueller_preis('formatA5'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="formatA5" name="formatA5" min="0" step="0.01" class="text-right">
                        </div>

                        <!-- A4 Gruppe -->
                        <div class="format-group">
                            <label for="formatA4">Format A4</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-formatA4">
                                <?php echo druckrechner_get_aktueller_preis('formatA4'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="formatA4" name="formatA4" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">

                <!-- 2. Grammatur (80, 100, 120 in einer Linie) -->
                <div>
                    <h4 >2. Grammatur (in g/m²)</h4>
                    <div class="format-section">
                        
                        <!-- 80 g/m² Gruppe -->
                        <div class="format-group">
                            <label for="grammatur80">80</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-grammatur80">
                                <?php echo druckrechner_get_aktueller_preis('grammatur80'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="grammatur80" name="grammatur80" min="0" step="0.01" class="text-right">
                        </div>

                        <!-- 100 g/m² Gruppe -->
                        <div class="format-group">
                            <label for="grammatur100">100</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-grammatur100">
                                <?php echo druckrechner_get_aktueller_preis('grammatur100'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="grammatur100" name="grammatur100" min="0" step="0.01" class="text-right">
                        </div>
                        
                        <!-- 120 g/m² Gruppe -->
                        <div class="format-group">
                            <label for="grammatur120">120</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-grammatur120">
                                <?php echo druckrechner_get_aktueller_preis('grammatur120'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="grammatur120" name="grammatur120" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">

                <!-- 3. Seitendruck (Einseitig und Beidseitig in einer Linie) -->
                <div>
                    <h4 >3. Seitendruck :</h4>
                    <div class="format-section">
                        <!-- Einseitig Gruppe -->
                        <div class="format-group">
                            <label for="einseitig">Einseitig:</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-einseitig">
                                <?php echo druckrechner_get_aktueller_preis('einseitig'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="einseitig" name="einseitig" min="0" step="0.01" class="text-right">
                        </div>

                        <!-- Beidseitig Gruppe -->
                        <div class="format-group">
                            <label for="beidseitig">Beidseitig:</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-beidseitig">
                                <?php echo druckrechner_get_aktueller_preis('beidseitig'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="beidseitig" name="beidseitig" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">


 <!-- 4.5.6. Seiten (Einzelne Zeile) -->
              <!-- 4. Seiten (Einzelne Zeile) -->
            <div>
            
            <div class="format-section">
                    
                    <div class="format-group">
                     <h4 >4. Seiten :</h4>  
                        <label for="seiten">Seiten :</label>
                        <span class="actual-price-label">Aktueller Preis:</span>
                        <span class="actual-price-value" id="aktuell-preis-seiten">
                            <?php echo druckrechner_get_aktueller_preis('Seiten'); ?>
                        </span>
                        <span class="neue-price-label">Neuer Preis:</span>
                        <input type="number" id="seiten" name="seiten" min="0" step="0.01" class="text-right">
                    </div>
            </div>
            </div>
<div>
                <!-- 5. Farbseiten (Einzelne Zeile) -->
                    
                    
                    <div class="format-group">
                        <h4 >5. Farbseiten</h4>
                        
                                        <label for="farbseiten">Farbseiten :</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell-preis-farbseiten">
                                            <?php echo druckrechner_get_aktueller_preis('Farbseiten'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="farbseiten" name="farbseiten" min="0" step="0.01" class="text-right">
                    </div>
                    </div>
</div>
                   <!-- 6. Exemplare --> 
                    <div class="format-group">
                        <h4 >6. Exemplare </h4>
                                        <label for="anzahl_exemplare">Exemplare :</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell-preis-exemplare">
                                            <?php echo druckrechner_get_aktueller_preis('anzahl_exemplare'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="anzahl_exemplare" name="anzahl_exemplare" min="0" step="0.01" class="text-right">
 
                    </div>
            </div>
                      <hr class="full-width-separator">
              <!-- 7. Bindung -->
                      <!--  <div>
                                <h4 >7. Bindung</h4>
                            <div class="format-section">
                                
                                        <label for="bindung_premium_lederoptik">Premium Lederoptik</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_bindung_premium_lederoptik">
                                            <?php echo druckrechner_get_aktueller_preis('bindung_premium_lederoptik'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="bindung_premium_lederoptik" name="bindung_premium_lederoptik" min="0" step="0.01" class="text-right">
                                </div>
                               
                               <div class="format-group">
                                        <label for="einband_premium_lederoptik_bordeaux">Einband : bordeaux</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_einband_premium_lederoptik_bordeaux">
                                            <?php echo druckrechner_get_aktueller_preis('einband_premium_lederoptik_bordeaux'); ?>
                                        </span>
                                        <span class="actual-price-label">Neue Preis:</span>
                                        <input type="number" id="einband_premium_lederoptik_bordeaux" name="einband_premium_lederoptik_bordeaux" min="0" step="0.01" class="text-right">
                                </div>
                                
                                <div class="format-group">
                                        <label for="einband_premium_lederoptik_blau">Einband : blau</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_einband_premium_lederoptik_blau">
                                            <?php echo druckrechner_get_aktueller_preis('einband_premium_lederoptik_blau'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="einband_premium_lederoptik_blau" name="einband_premium_lederoptik_blau" min="0" step="0.01" class="text-right">
                                </div>
                            </div>
                            <hr class="halb-width-separator">
                             <div class="format-section">
                                <div class="format-group">
                                        <label for="einband_premium_lederoptik_anthrazit">Einband : anthrazit</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_einband_premium_lederoptik_anthrazit">
                                            <?php echo druckrechner_get_aktueller_preis('einband_premium_lederoptik_anthrazit'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="einband_premium_lederoptik_anthrazit" name="einband_premium_lederoptik_anthrazit" min="0" step="0.01" class="text-right">
                                </div>
                               <div class="format-group">
                                        <label for="einband_premium_lederoptik_schwarz">Einband : schwarz</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_einband_premium_lederoptik_schwarz">
                                            <?php echo druckrechner_get_aktueller_preis('einband_premium_lederoptik_schwarz'); ?>
                                        </span>
                                        <span class="actual-price-label">Neue Preis:</span>
                                        <input type="number" id="einband_premium_lederoptik_schwarz" name="einband_premium_lederoptik_schwarz" min="0" step="0.01" class="text-right">
                                </div>
                                </div>
                               <hr class="full-width-separator"> 
                               
                                
                               <!-- <div class="format-section">
                                        <div class="format-group">
                                                <label for="bindung_klemmbuch">Klemmbuch</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_bindung_klemmbuch">
                                                    <?php echo druckrechner_get_aktueller_preis('bindung_klemmbuch'); ?>
                                                </span>
                                                <span class="actual-price-label">Neue Preis:</span>
                                                <input type="number" id="bindung_klemmbuch" name="bindung_klemmbuch" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_klemmbuch_bordeaux">Einband : bordeaux</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_bindung_einband_klemmbuch_bordeaux">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_klemmbuch_bordeaux'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_klemmbuch_bordeaux" name="einband_klemmbuch_bordeaux" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_klemmbuch_blau">Einband : blau</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_klemmbuch_blau">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_klemmbuch_blau'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_klemmbuch_blau" name="einband_klemmbuch_blau" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>
                                <div class="format-section">
                                    <div class="format-group">
                                     
                                        <label for="einband_klemmbuch_grun">Einband : grün</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_einband_klemmbuch_grun">
                                            <?php echo druckrechner_get_aktueller_preis('einband_klemmbuch_grun'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="einband_klemmbuch_grun" name="einband_klemmbuch_grun" min="0" step="0.01" class="text-right">
                                    </div>
                                
                            

                                
                                    <div class="format-group">
                                        <label for="einband_klemmbuch_beige">Einband : beige</label>
                                        <span class="actual-price-label">Aktueller Preis:</span>
                                        <span class="actual-price-value" id="aktuell_preis_einband_klemmbuch_beige">
                                            <?php echo druckrechner_get_aktueller_preis('einband_klemmbuch_beige'); ?>
                                        </span>
                                        <span class="neue-price-label">Neuer Preis:</span>
                                        <input type="number" id="einband_klemmbuch_beige" name="einband_klemmbuch_beige" min="0" step="0.01" class="text-right">
                                    </div>
                                </div>
                                    <hr class="full-width-separator">
                            
                            
                                <div class="format-section">
                                        <div class="format-group">
                                                <label for="bindung_premium_kaschmirleinenoptik">Premium Kaschmirleinenoptik</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_bindung_premium_kaschmirleinenoptik">
                                                    <?php echo druckrechner_get_aktueller_preis('bindung_premium_kaschmirleinenoptik'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="bindung_premium_kaschmirleinenoptik" name="bindung_premium_kaschmirleinenoptik" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_premium_kaschmirleinenoptik_blau">Einband : blau</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_premium_kaschmirleinenoptik_blau">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_premium_kaschmirleinenoptik_blau'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_premium_kaschmirleinenoptik_blau" name="einband_premium_kaschmirleinenoptik_blau" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_premium_kaschmirleinenoptik_beige">Einband : beige</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_premium_kaschmirleinenoptik_beige">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_premium_kaschmirleinenoptik_beige'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_premium_kaschmirleinenoptik_beige" name="einband_premium_kaschmirleinenoptik_beige" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>
                                <div class="format-section">
                                        <div class="format-group">
                                                <label for="einband_premium_kaschmirleinenoptik_dunkelgrau">Einband : dunkelgrau</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_premium_kaschmirleinenoptik_dunkelgrau">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_premium_kaschmirleinenoptik_dunkelgrau'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_premium_kaschmirleinenoptik_dunkelgrau" name="einband_premium_kaschmirleinenoptik_dunkelgrau" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>
                            <hr class="full-width-separator">
                 
                            <div class="format-section">
                                    <div class="format-group">
                                            <label for="bindung_plastringbindung">Plastringbindung</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_bindung_plastringbindung">
                                                <?php echo druckrechner_get_aktueller_preis('bindung_plastringbindung'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="bindung_plastringbindung" name="bindung_plastringbindung" min="0" step="0.01" class="text-right">
                                    </div>
                                    
                                    <div class="format-group">
                                            <label for="bindung_drahtringbindung">Drahtringbindung</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_bindung_drahtringbindung">
                                                <?php echo druckrechner_get_aktueller_preis('bindung_drahtringbindung'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="bindung_drahtringbindung" name="bindung_drahtringbindung" min="0" step="0.01" class="text-right">
                                    </div>
                            </div>
                            <hr class="full-width-separator">
                            
                            <div class="format-section">
                                    <div class="format-group">
                                            <label for="bindung_faelzelband">Fälzelband</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_bindung_faelzelband">
                                                <?php echo druckrechner_get_aktueller_preis('bindung_faelzelband'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="bindung_faelzelband" name="bindung_faelzelband" min="0" step="0.01" class="text-right">
                                    </div>-->
                                   <!-- <div class="format-group">
                                            <label for="einband_faelzelband_blau">Einband : blau</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_einband_faelzelband_blau">
                                                <?php echo druckrechner_get_aktueller_preis('einband_faelzelband_blau'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="einband_faelzelband_blau" name="einband_faelzelband_blau" min="0" step="0.01" class="text-right">
                                    </div>
                                    <div class="format-group">
                                            <label for="einband_faelzelband_bordeaux">Einband : bordeaux</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_einband_faelzelband_bordeaux">
                                                <?php echo druckrechner_get_aktueller_preis('einband_faelzelband_bordeaux'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="einband_faelzelband_bordeaux" name="einband_faelzelband_bordeaux" min="0" step="0.01" class="text-right">
                                    </div>
                            </div>
                            <hr class="halb-width-separator">
                                <div class="format-section">
                                        <div class="format-group">
                                            <label for="einband_faelzelband_anthrazit">Einband: anthrazit</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_einband_faelzelband_anthrazit">
                                                <?php echo druckrechner_get_aktueller_preis('einband_faelzelband_anthrazit'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="einband_faelzelband_anthrazit" name="einband_faelzelband_anthrazit" min="0" step="0.01" class="text-right">
                                        </div>
                                
                                        <div class="format-group">
                                            <label for="einband_faelzelband_schwarz">Einband: schwarz</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_einband_faelzelband_schwarzz">
                                                <?php echo druckrechner_get_aktueller_preis('einband_faelzelband_schwarz'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="einband_faelzelband_schwarz" name="einband_faelzelband_schwarz" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                            <label for="einband_faelzelband_grun">Einband: grun</label>
                                            <span class="actual-price-label">Aktueller Preis:</span>
                                            <span class="actual-price-value" id="aktuell_preis_einband_faelzelband_grun">
                                                <?php echo druckrechner_get_aktueller_preis('einband_faelzelband_grun'); ?>
                                            </span>
                                            <span class="neue-price-label">Neuer Preis:</span>
                                            <input type="number" id="einband_faelzelband_grun" name="einband_faelzelband_grun" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>-->

                           <!-- <hr class="full-width-separator">
                        
                                <div class="format-section">
                                        <div class="format-group">
                                                <label for="bindung_heissleimbindung">Heißleimbindung</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_bindung_heissleimbindung">
                                                    <?php echo druckrechner_get_aktueller_preis('bindung_heissleimbindung'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="bindung_heissleimbindung" name="bindung_heissleimbindung" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_heissleimbindung_eigene_geschaltung">Einband: eigene geschaltung</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_heissleimbindung_eigene_geschaltung">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_heissleimbindung_eigene_geschaltung'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_heissleimbindung_eigene_geschaltung" name="einband_heissleimbindung_eigene_geschaltung" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_heissleimbindung_vorne_hinten_blau">Einband: vorne hinten blau</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_heissleimbindung_vorne_hinten_blau">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_heissleimbindung_vorne_hinten_blau'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_heissleimbindung_vorne_hinten_blau" name="einband_heissleimbindung_vorne_hinten_blau" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>
                                <div class="format-section">
                                        <div class="format-group">
                                                <label for="einband_heissleimbindung_matte_hinten_blau">Einband: matte hinten blau</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_heissleimbindung_matte_hinten_blau">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_heissleimbindung_matte_hinten_blau'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_heissleimbindung_matte_hinten_blau" name="einband_heissleimbindung_matte_hinten_blau" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_heissleimbindung_vorne_hinten_bordeaux">Einband: vorne hinten bordeaux</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_heissleimbindung_vorne_hinten_bordeaux">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_heissleimbindung_vorne_hinten_bordeaux'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_heissleimbindung_vorne_hinten_bordeaux" name="einband_heissleimbindung_vorne_hinten_bordeaux" min="0" step="0.01" class="text-right">
                                        </div>
                                        <div class="format-group">
                                                <label for="einband_heissleimbindung_matte_hinten_bordeaux">Einband: matte hinten bordeaux</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_einband_heissleimbindung_matte_hinten_bordeaux">
                                                    <?php echo druckrechner_get_aktueller_preis('einband_heissleimbindung_matte_hinten_bordeaux'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="einband_heissleimbindung_matte_hinten_bordeaux" name="einband_heissleimbindung_matte_hinten_bordeaux" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>
                              <hr class="full-width-separator">
                               
                                <div class="format-section">
                                        <div class="format-group">
                                                <label for="bindung_kammbindung">Kammbindung</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preis_bindung_kammbindung">
                                                    <?php echo druckrechner_get_aktueller_preis('bindung_kammbindung'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="bindung_kammbindung" name="bindung_kammbindung" min="0" step="0.01" class="text-right">
                                        </div>
                                        
                                        <div class="format-group">
                                                <label for="bindung_rueckstichheftung">Rückstichheftung</label>
                                                <span class="actual-price-label">Aktueller Preis:</span>
                                                <span class="actual-price-value" id="aktuell_preisbindung_rueckstichheftung">
                                                    <?php echo druckrechner_get_aktueller_preis('bindung_rueckstichheftung'); ?>
                                                </span>
                                                <span class="neue-price-label">Neuer Preis:</span>
                                                <input type="number" id="bindung_rueckstichheftung" name="bindung_rueckstichheftung" min="0" step="0.01" class="text-right">
                                        </div>
                                </div>-->
    
                        <hr class="full-width-separator">

                         <!-- 8. Einband  -->
                
                    <!--const filterEinband = {
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
                    };-->
              
                
                <!-- 9. Prägung< -->
                <div>
                    <h4>9. Prägung</h4>
                    <div class="format-section">
                        <!-- A5 Gruppe -->
                        <div class="format-group">
                            <label for="praegung_checkbox">Prägung</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_praegung_checkbox">
                                <?php echo druckrechner_get_aktueller_preis('praegung_checkbox'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="praegung_checkbox" name="praegung_checkbox" min="0" step="0.01" class="text-right">
                        </div>

                        <!-- >Schriftart -->
                         </h5>9.1 Schriftart</h5>
                        <div class="format-group">
                            <label for="schriftart_helv">Helvetica</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-a4">
                                <?php echo druckrechner_get_aktueller_preis('schriftart_helv'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="schriftart_helv" name="schriftart_helv" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                 <!-- Farbe-->
                <div>
                     <h4 >9.2 Farbe:</h4>
                    <div class="format-section">
                         
                        <div class="format-group">

                            <label for="farbe_gold">Gold</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_farbe_gold">
                                <?php echo druckrechner_get_aktueller_preis('farbe_gold'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="farbe_gold" name="farbe_gold" min="0" step="0.01" class="text-right">
                        </div>

                        <div class="format-group">
                            <label for="farbe_silber">Silber</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_farbe_silber">
                                <?php echo druckrechner_get_aktueller_preis('farbe_silber'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="farbe_silber" name="farbe_silber" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">
                                <!-- 10. Einband vorn-->
                <div>
                    <h3 >10. Einband vorn: </h3>
                     <!-- 10/1. einband_vorn -->
                    <div class="format-section">
                       
                        <div class="format-group">
                            <label for="ev_folie_matt">Folie matt</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_folie_matt">
                                <?php echo druckrechner_get_aktueller_preis('ev_folie_matt'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_folie_matt" name="ev_folie_matt" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="ev_karton_rot">Karton rot</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_rot">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_rot'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_rot" name="ev_karton_rot" min="0" step="0.01" class="text-right">
                        </div>
                    
                    
                        <div class="format-group">
                            <label for="ev_karton_bordeaux">Karton bordeaux</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_bordeaux">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_bordeaux'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_bordeaux" name="ev_karton_bordeaux" min="0" step="0.01" class="text-right">
                        </div>

                    </div>
                    <!-- 10/2. einband_vorn -->
                        <div class="format-section">
                        
                        <div class="format-group">
                            <label for="ev_karton_blau">Karton blau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_blau">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_blau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_blau" name="ev_karton_blau" min="0" step="0.01" class="text-right">
                        </div>
                   
                        <div class="format-group">
                            <label for="ev_karton_hellblau">Karton hellblau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_hellblau">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_hellblau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_hellblau" name="ev_karton_hellblau" min="0" step="0.01" class="text-right">
                        </div>

                        <div class="format-group">
                            <label for="ev_karton_olive">Karton olive</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_olive">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_olive'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_olive" name="ev_karton_olive" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                
                <div class="format-section">
                        <!-- einband_vorn 3 Gruppe -->
                        <div class="format-group">
                            <label for="ev_karton_grun">Karton grün</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_grun">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_grun'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_grun" name="ev_karton_grun" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="ev_karton-gelb">Karton gelb</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_gelb">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_gelb'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_gelb" name="ev_karton_gelb" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            <label for="ev_karton_weiss">Karton weiß</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis-ev_karton_weiss">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_weiss'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_weiss" name="ev_karton_weiss" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                    <!-- 10/3. einband_vorn -->
                    <div class="format-section">
                        
                        <div class="format-group">
                            <label for="ev_karton_grau">Karton grau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_grau">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_grau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_grau" name="ev_karton_grau" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="ev_karton_schwarz">Karton schwarz</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ev_karton_schwarz">
                                <?php echo druckrechner_get_aktueller_preis('ev_karton_schwarz'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ev_karton_schwarz" name="ev_karton_schwarz" min="0" step="0.01" class="text-right">
                        </div>
                       
                    </div>
                </div>
                <hr class="full-width-separator">
                 <!-- 11. Einband hinten -->
                <div>
                    <h4 >11. Einband hinten</h4>
                    
                        <!-- 11/1 Gruppe -->
                    <div class="format-section">
                       
                        <div class="format-group">
                            <label for="eh_folie_matt">Folie matt</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_folie_matt">
                                <?php echo druckrechner_get_aktueller_preis('eh_folie_matt'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_folie_matt" name="eh_folie_matt" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="eh_karton_rot">Karton rot</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_rot">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_rot'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_rot" name="eh_karton_rot" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            <label for="eh_karton_bordeaux">Karton bordeaux</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_bordeaux">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_bordeaux'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_bordeaux" name="eh_karton_bordeaux" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                     <!-- 11/2 Gruppe -->
                    <div class="format-section">
                       
                        <div class="format-group">
                            <label for="eh_karton_blau">Karton blau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_blau">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_blau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_blau" name="eh_karton_blau" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            <label for="eh_karton_hellblau">Karton hellblau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_hellblau">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_hellblau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_hellblau" name="eh_karton_hellblau" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="eh_karton_olive">Karton olive</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_olive">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_olive'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_olive" name="eh_karton_olive" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                    
                     <!-- 11/3 Gruppe -->
                    <div class="format-section">
                       
                        <div class="format-group">
                            <label for="eh_karton_grun">Karton grün</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_grun">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_grun'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_grun" name="eh_karton_grun" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="eh_karton_gelb">Karton gelb</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_gelb">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_gelb'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_gelb" name="eh_karton_gelb" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            <label for="eh_karton_weiss">Karton weiß</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_weiss">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_weiss'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_weiss" name="eh_karton_weiss" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                    <!-- 11/4 Gruppe -->
                    <div class="format-section"> 
                        <div class="format-group">
                            <label for="eh_karton_grau">Karton grau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_grau">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_grau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_grau" name="eh_karton_grau" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            <label for="eh_karton_schwarz">Karton schwarz</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_eh_karton_schwarz">
                                <?php echo druckrechner_get_aktueller_preis('eh_karton_schwarz'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="eh_karton_schwarz" name="eh_karton_schwarz" min="0" step="0.01" class="text-right">
                        </div>

                    </div>
                </div>
                <hr class="full-width-separator">
                        <!-- 12. Ringfarbe: -->
                <div>
                    <h4 >12. Ringfarbe:</h4>
                    <div class="format-section">
                        
                         
                        <div class="format-group">
                            <!-- 12/1. Ringfarbe -->
                            <label for="ringfarbe_schwarz">Schwarz</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ringfarbe_schwarz">
                                <?php echo druckrechner_get_aktueller_preis('ringfarbe_schwarz'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ringfarbe_schwarz" name="ringfarbe_schwarz" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="ringfarbe_weiss">Weiß</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ringfarbe_weiss">
                                <?php echo druckrechner_get_aktueller_preis('ringfarbe_weiss'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ringfarbe_weiss" name="ringfarbe_weiss" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            
                            <label for="ringfarbe_blau">Blau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ringfarbe_blau">
                                <?php echo druckrechner_get_aktueller_preis('ringfarbe_blau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ringfarbe_blau" name="ringfarbe_blau" min="0" step="0.01" class="text-right">
                        </div>
                        </div>
                      <div class="format-section">
                        <!-- 12/1. Ringfarbe -->
                        <div class="format-group">
                            <label for="ringfarbe_rot">Rot</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_ringfarbe_rot">
                                <?php echo druckrechner_get_aktueller_preis('ringfarbe_rot'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="ringfarbe_rot" name="ringfarbe_rot" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">
                                <!-- 13. Kammfarbe-->
                <div>
                   <h4 >13. Kammfarbe:</h4> 
                    <div class="format-section">
                        
                        
                        <div class="format-group">
                            <label for="kammfarbe_schwarz">Schwarz</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_kammfarbe_schwarz">
                                <?php echo druckrechner_get_aktueller_preis('kammfarbe_schwarz'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="kammfarbe_schwarz" name="kammfarbe_schwarz" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="kammfarbe_weiss">Weiß</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_kammfarbe_weiss">
                                <?php echo druckrechner_get_aktueller_preis('kammfarbe_weiss'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="kammfarbe_weiss" name="kammfarbe_weiss" min="0" step="0.01" class="text-right">
                        </div>
                        
                        
                        <div class="format-group">
                            <label for="kammfarbe_dunkelblau">Dunkelblau</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_kammfarbe_dunkelblau">
                                <?php echo druckrechner_get_aktueller_preis('kammfarbe_dunkelblau'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="kammfarbe_dunkelblau" name="kammfarbe_dunkelblau" min="0" step="0.01" class="text-right">
                        </div>
                        <div class="format-group">
                            <label for="kammfarbe_bordeaux">Bordeaux</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_kammfarbe_bordeaux">
                                <?php echo druckrechner_get_aktueller_preis('kammfarbe_bordeaux'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="kammfarbe_bordeaux" name="kammfarbe_bordeaux" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">
                                <!-- 14. Format (A5 und A4 in einer Linie) -->
                <!--<div>
                    <h4 >14. Arbeit/Name:</h4>
                    <div class="format-section">
                        
                         
                        <div class="format-group">
                            
                            <label for="arbeit_name">Arbeit/Name</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-arbeit_name">
                                <?php echo druckrechner_get_aktueller_preis('Arbeit/Name'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="arbeit_name" name="arbeit_name" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">-->
                                               <!-- 15. Farbe: -->
<div>
                    <h4 >15. Fälzelbandfarbe:</h4>
                    <div class="format-section">

                            <div class="format-group">
                                
                                    <label for="faelzelb_weiss">Weiß</label>
                                    <span class="actual-price-label">Aktueller Preis:</span>
                                    <span class="actual-price-value" id="aktuell_preis_faelzelb_weiss">
                                        <?php echo druckrechner_get_aktueller_preis('faelzelb_weiss'); ?>
                                    </span>
                                    <span class="neue-price-label">Neuer Preis:</span>
                                    <input type="number" id="faelzelb_weiss" name="faelzelb_weiss" min="0" step="0.01" class="text-right">
                            </div>
                            <div class="format-group">
                                
                                    <label for="faelzelb_schwarz">Schwarz</label>
                                    <span class="actual-price-label">Aktueller Preis:</span>
                                    <span class="actual-price-value" id="aktuell_preis_faelzelb_schwarz">
                                        <?php echo druckrechner_get_aktueller_preis('faelzelb_schwarz'); ?>
                                    </span>
                                    <span class="neue-price-label">Neuer Preis:</span>
                                    <input type="number" id="faelzelb_schwarz" name="faelzelb_schwarz" min="0" step="0.01" class="text-right">
                            </div>
                            <div class="format-group">
                                
                                    <label for="faelzelb_dunkelblau">Dunkelblau</label>
                                    <span class="actual-price-label">Aktueller Preis:</span>
                                    <span class="actual-price-value" id="aktuell_preis_faelzelb_dunkelblau">
                                        <?php echo druckrechner_get_aktueller_preis('faelzelb_dunkelblau'); ?>
                                    </span>
                                    <span class="neue-price-label">Neuer Preis:</span>
                                    <input type="number" id="faelzelb_dunkelblau" name="faelzelb_dunkelblau" min="0" step="0.01" class="text-right">
                            </div>
                    </div>
                    <div class="format-section">
                            <div class="format-group">
                                
                                    <label for="faelzelb_rot">Rot</label>
                                    <span class="actual-price-label">Aktueller Preis:</span>
                                    <span class="actual-price-value" id="aktuell_preis_faelzelb_rot">
                                        <?php echo druckrechner_get_aktueller_preis('faelzelb_rot'); ?>
                                    </span>
                                    <span class="neue-price-label">Neuer Preis:</span>
                                    <input type="number" id="faelzelb_rot" name="faelzelb_rot" min="0" step="0.01" class="text-right">
                            </div>
                    </div>
                </div>
                <hr class="full-width-separator">

                <!-- 16. CD -->
                <div>
                    <h4 >16. CD</h4>
                    <div class="format-section">
                        
                        
                        <div class="format-group">
                            <label for="cd">CD</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell_preis_cd">
                                <?php echo druckrechner_get_aktueller_preis('cd'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="cd" name="cd" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="cd_huelle">CD Hülle </label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-cd-huelle">
                                <?php echo druckrechner_get_aktueller_preis('cd_huelle'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="cd_huelle" name="cd_huelle" min="0" step="0.01" class="text-right">
                        </div>
                        
                      
                        <div class="format-group">
                            <label for="cd_direktdruck">CD-Direktdruck</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-cd-direktdruck">
                                <?php echo druckrechner_get_aktueller_preis('cd_direktdruck'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="cd_direktdruck" name="cd_direktdruck" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>
                <hr class="full-width-separator">
                 
              
               <!-- <div>
                    <h4 >17. Lieferung</h4>
                    <div class="format-section">
                        
                         
                        <div class="format-group">
                    
                            <label for="versandart_abholung">Abholung</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-versandart-abholung">
                                <?php echo druckrechner_get_aktueller_preis('Abholung'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="versandart_abholung" name="versandart_abholung" min="0" step="0.01" class="text-right">
                        </div>

                        
                        <div class="format-group">
                            <label for="versandart_1_2_werktage">1-2 Werktage</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-versandart_1_2_werktage">
                                <?php echo druckrechner_get_aktueller_preis('1-2 Werktage'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="versandart_1_2_werktage" name="versandart_1_2_werktage" min="0" step="0.01" class="text-right">
                        </div>
                    </div>
                </div>-->
                <hr class="full-width-separator">
                 
                <!-- 18. Zahlungsart: 
                <div>
                   <h4 >18. Zahlungsart:</h4>
                    <div class="format-section">
                        
                          
                        <div class="format-group">
                           
                            <label for="zahlungsart_nachname">Nachname</label>
                            <span class="actual-price-label">Aktueller Preis:</span>
                            <span class="actual-price-value" id="aktuell-preis-zahlungsart-nachname">
                                <?php echo druckrechner_get_aktueller_preis('Nachname'); ?>
                            </span>
                            <span class="neue-price-label">Neuer Preis:</span>
                            <input type="number" id="zahlungsart_nachname" name="zahlungsart_nachname" min="0" step="0.01" class="text-right">
                        </div>

                        
                    </div>
                </div>
                <hr class="full-width-separator">-->
                                          <!-- Button -->
                                            <button type="submit" name="druckrechner_submit" id="saveButton" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg mt-8 transition duration-150 ease-in-out disabled:opacity-50">
                                Preise speichern
                            </button>
     </form>

                      
                
                    
                
                 </div>
   
     
            
    



 




