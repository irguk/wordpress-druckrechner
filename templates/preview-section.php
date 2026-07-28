<!-- preview-section.php -->
<div class="col-md-6 ">
    <h3>Ihr Wunschprodukt</h3>
    <div class="row g-3 " id="vorschau-block">
        <div class="col-6" id="smallpreviewimg">
            <!-- Vorschau-Inhalt hier -->
             
                                    <div class="bild-container" id="bildContainer">
                                        <img id="previewimg" src="/wp-content/plugins/druckrechner/previewimg.php" alt="Vorschau Produkt">
                                        
                                        <!--<div id="zoom-lupe" style="display: none;"></div>-->
                                    </div>
                                  
                           </div>
                           <div class="col-6">
							<p >Hier sehen Sie eine Vorschau Ihres erstellten Produktes und den finalen Preis:</p>
                           
                        </div>
                        

                      <!-- 🔒 Statischer Teil -->
                        <div class="info" id="produkt-details">
                
                
                                <p><strong>Seitendruck:</strong> <span id="preview-seitendruck">–</span></p>
                                <p><strong>Seiten:</strong> <span id="preview-seiten">–</span>, davon <span id="preview-farbseiten">–</span> farbig</p>
                                <p><strong>Format:</strong> <span id="preview-format">–</span></p>
                                <p><strong>Grammatur:</strong> <span id="preview-grammatur">–</span></p>
                             
                            <hr> <div id="cd-details" style="display: none;">
                                    <p><strong>CD (Optional):</strong> Ja</p>
                                    <p style="margin-left: 15px;">
                                        <strong>Stück:</strong> <span id="preview-cd-stueck">–</span><br>
                                        <strong>Hülle (selbstklebend):</strong> <span id="preview-cd-huelle">Nein</span><br>
                                        <strong>Direktdruck:</strong> <span id="preview-cd-direktdruck">Nein</span>
                                    </p>
                                </div>
                        </div>
                        <!--<div class="info" id="bindung-details">
                            <img src="/wp-content/plugins/druckrechner/templates/img/ohne.jpg" id="previewimg" alt="Vorschau" >
                            <p><strong>Ihre Bindung:</strong> <span id="preview-bindung">Ohne</span></p>
                            <p><strong>text:</strong> <span id="bindung-erklärung">–</span></p>
                        </div>-->
			            <div class="row g-3" id="bindung-details">
                            <div class="col-6">
                                <img src="/wp-content/plugins/druckrechner/templates/img/ohne.jpg" id="preview-bindung-img" alt="Vorschau Bindung" >
                            </div>
                            <div class="col-6">
                                <p><strong>Ihre Bindung:</strong> <span id="preview-bindung">Ohne</span></p>
                                <p><span id="bindung-erklärung">–</span></p>
                            </div>
                        </div>

                        <!-- 🔁Dynamischer Teil -->
                        <div class="info gesamt_rechnen" id="preis-details">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h5>Anzahl</h5>
                                    <p id="preview-exemplare">– Exemplare</p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Einzelpreis</h5>
                                    <p id="preview-einzelpreis">– €</p>
                                </div>
                                <div class="col-md-4">
                                    <h5>Gesamt</h5>
                                    <p id="preview-gesamtpreis">– €</p>
                                </div>
                            </div>

                            <div class="versandkosten mt-3 ">
                               <p>zzgl. €0,00 Versandkosten</p>
                            </div>
                            <div class="nachnahme-kosten mt-3 ">
                                <p class="kosten-text" id="nachnahmeKostenOutput">zzgl. €0,00 Nachnahme</p>
                            </div>

                            <div class="kommentar mt-3">
                                    <p>* (Brutto) – Die Preise beinhalten die gesetzliche Mehrwertsteuer:<br>
                                        7% für Privatpersonen<br>
                                        19% für Firmenkunden
                                    </p>
                                    <p>Die Preise sind unverbindlich und erlangen mit der Zusendung der Auftragsbestätigung ihre Gültigkeit.</p>
                            </div>
                  
        </div>
    </div>
</div>
<!-- Ende preview-section.php -->