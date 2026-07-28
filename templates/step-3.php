<div class="container">
    <div class="step3" id="lieferForm">
        <h2>Schritt 3: Datei hochladen und Bestellung abschließen</h2>
        
        <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
            <div class="mb-3">
                <label for="uploaded_file">Druckdaten:</label>
                <input type="file" id="fileInput" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                <p class="small" id="fileStatus">Erlaubt: pdf, doc, docx, jpg, png. Max. 20 MB.</p>
                
                <button type="button" id="uploadBtn" class="btn btn-warning mt-2">Datei Laden</button>
                
                <div id="uploadProgress" style="display:none; margin-top:10px;">
                    <div class="progress">
                        <div id="progressBar" class="progress-bar bg-success" style="width: 0%"></div>
                    </div>
                    <span id="statusText">Wird hochgeladen...</span>
                </div>
            </div>
        </div>

        <form action="" method="post" id="orderForm">
            <input type="hidden" name="uploaded_file_name" id="uploaded_file_name">

            <div class="mb-3">
                <label for="message">Ihre Nachricht (optional):</label>
                <textarea rows="3" name="message" class="form-control"></textarea>
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" name="vertragssprache" required>
                <label>Die Vertragssprache ist Deutsch.</label>
            </div>
            
            <div class="form-check mb-4">
                <input type="checkbox" name="agb_akzeptiert" required>
                <label>Ich akzeptiere die AGB's.</label>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" name="go_back_to_step2" class="btn btn-secondary" formnovalidate>Zurück</button>
                <input type="submit" name="final_submit" class="btn btn-success" value="Zahlungspflichtig bestellen">
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('uploadBtn').addEventListener('click', function() {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];
    
    if (!file) {
        alert("Bitte wählen Sie zuerst eine Datei aus.");
        return;
    }

    const formData = new FormData();
    formData.append('file', file);

    // Fortschritt anzeigen
    document.getElementById('uploadProgress').style.display = 'block';
    const progressBar = document.getElementById('progressBar');
    const statusText = document.getElementById('statusText');

    const xhr = new XMLHttpRequest();
    
    // Hier musst du die URL zu deinem PHP-Upload-Script angeben (z.B. upload.php)
    xhr.open('POST', 'upload_handler.php', true);

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            progressBar.style.width = percentComplete + '%';
        }
    };

    xhr.onload = function() {
        if (xhr.status === 200) {
            statusText.innerText = "Datei erfolgreich geladen!";
            // Speichere den Dateinamen im versteckten Feld für die E-Mail
            document.getElementById('uploaded_file_name').value = xhr.responseText;
        } else {
            statusText.innerText = "Fehler beim Upload.";
        }
    };

    xhr.send(formData);
});
</script>