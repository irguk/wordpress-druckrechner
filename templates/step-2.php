<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2>Schritt 2: Rechnungsadresse und Kontaktdaten</h2>
            <form action="" method="post" id="kundenForm">
                
                  <input type="hidden" name="step2_submit" value="1">

                  <h4 class="mt-4 mb-3">Rechnungsadresse</h4>
                
                    <div class="row mb-3 align-items-center">
                        <label for="titel" class="col-sm-2 col-form-label text-sm-start">Titel:</label>
                        <div class="col-sm-10">
                            <input type="text" name="titel" id="titel" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="anrede" class="col-sm-2 col-form-label text-sm-start">Anrede: *</label>
                        <div class="col-sm-10">
                            <select id="anrede" name="anrede" class="form-select" required>
                                <option value="" selected disabled>---</option>
                                <option value="herr">Herr</option>
                                <option value="frau">Frau</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="vorname" class="col-sm-2 col-form-label text-sm-start">Vorname: *</label>
                        <div class="col-sm-10">
                            <input type="text" name="vorname" id="vorname" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="nachname" class="col-sm-2 col-form-label text-sm-start">Nachname: *</label>
                        <div class="col-sm-10">
                            <input type="text" name="nachname" id="nachname" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="strasse" class="col-sm-2 col-form-label text-sm-start">Strasse/Nr.: *</label>
                        <div class="col-sm-10">
                            <input type="text" name="strasse" id="strasse" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="postleitzahl" class="col-sm-2 col-form-label text-sm-start">Postleitzahl: *</label>
                        <div class="col-sm-10">
                            <input type="text" name="postleitzahl" id="postleitzahl" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="ort" class="col-sm-2 col-form-label text-sm-start">Ort: *</label>
                        <div class="col-sm-10">
                            <input type="text" name="ort" id="ort" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="land" class="col-sm-2 col-form-label text-sm-start">Land: *</label>
                        <div class="col-sm-10">
                            <select id="land" name="land" class="form-select" required>
                                <option value="" selected disabled>---</option>
                                <option value="de">Deutschland</option>
                            </select>
                        </div>
                    </div>
                   
                    
                    <div class="row mb-4">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="andere_lieferadresse" id="andere_lieferadresse">
                                <label class="form-check-label" for="andere_lieferadresse">
                                    Andere Lieferadresse als die Rechnungsadresse
                                </label>
                            </div>
                        </div>
                    </div>
                
                
                
                    <div id="adresse_lieferung" style="display: none;">
                            <div class="row mb-3 align-items-center">
                                <label for="titel" class="col-sm-2 col-form-label text-sm-start" >Titel:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="titel" id="titel" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="anrede_adresse_lieferung" class="col-sm-2 col-form-label text-sm-start" >Anrede:</label>
                                <div class="col-sm-10">
                                <select id="anrede_adresse_lieferung" name="anrede_adresse_lieferung" class="form-select ">
                                        <option value="herr">Herr</option>
                                        <option value="frau">Frau</option>
                                </select>
                                </div>
                            </div> 
                        
                            <div class="row mb-3 align-items-center">
                                <label for="vorname_adresse_lieferung" class="col-sm-2 col-form-label text-sm-start" >Vorname:</label>
                                <div class="col-sm-10">
                                  <input type="text" name="vorname_adresse_lieferung" id="vorname_adresse_lieferung" class="form-control"  required><br>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="nachname_adresse_lieferung" class="col-sm-2 form-label text-sm-start" >Nachname:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nachname_adresse_lieferung" id="nachname_adresse_lieferung" class="form-control" required><br>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="strasse_adresse_lieferung" class="col-sm-2 form-label text-sm-start" >Strasse/Nr.:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="strasse_adresse_lieferung" id="strasse_adresse_lieferung" class="form-control" required><br>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="postleitzahl_adresse_lieferung" class="col-sm-2 col-form-label text-sm-start" >Postleitzahl:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="postleitzahl_adresse_lieferung" id="postleitzahl_adresse_lieferung" class="form-control" required><br>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="ort_adresse_lieferung" class="col-sm-2 col-form-label text-sm-start" >Ort:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="ort_adresse_lieferung" id="ort_adresse_lieferung" class="form-control" required><br>
                                </div>
                            </div>
                        
                            
                            
                    </div>

                     <div class="row mb-3 align-items-center">
                        <label for="email" class="col-sm-2 col-form-label text-sm-start">E-Mail: *</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <label for="tel" class="col-sm-2 col-form-label text-sm-start">Telefonnr: *</label>
                        <div class="col-sm-10">
                            <input type="tel" name="tel" id="tel" class="form-control" required>
                        </div>
                    </div>

				</div>
                
                    <div class="row mb-2">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kopie_anfrage" id="kopie_anfrage">
                                <label class="form-check-label" for="kopie_anfrage">
                                    Ich möchte eine Kopie dieser Anfrage erhalten
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="datenschutz" id="datenschutz" required>
                                <label class="form-check-label" for="datenschutz">
                                    Ich erkläre mich mit der Verarbeitung der eingegebenen Daten sowie der <a href="#">Datenschutzerklärung</a> einverstanden.
                                </label>
                            </div>
                        </div>
                    </div>
                
                    <div class="row justify-content-end">
                            <button type="submit" name="step2_submit" class="btn btn-warning w-100" style="background-image: linear-gradient(to top, #f0ad4e 0%, #ffc107 100%); border: none;">Weiter</button>
            
                    </div>
                
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('andere_lieferadresse');
        const lieferfelderDiv = document.getElementById('adresse_lieferung');

        // Liste aller Input-Felder in der Lieferadresse, die Pflichtfelder sind
        const requiredInputs = lieferfelderDiv.querySelectorAll('input[required], select[required]');

        function toggleLieferfelder() {
            if (checkbox.checked) {
                // ANZEIGEN: Setze Display auf 'block' und alle Inputs auf required
                lieferfelderDiv.style.display = 'block';
                requiredInputs.forEach(input => {
                    input.required = true;
                });
            } else {
                // VERSTECKEN: Setze Display auf 'none' und entferne 'required'
                lieferfelderDiv.style.display = 'none';
                requiredInputs.forEach(input => {
                    input.required = false;
                    // Optional: Fehlerstatus zurücksetzen, falls vom Browser gesetzt
                    input.value = ''; // Felder leeren
                });
            }
        }

        if (checkbox && lieferfelderDiv) {
             checkbox.addEventListener('change', toggleLieferfelder);
             toggleLieferfelder(); 
        }
    });
</script>
