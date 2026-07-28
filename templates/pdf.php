<?php
/**
 * Datei: pdf.php
 * Speicherort: /druckrechner/templates/pdf.php
 */

// 1. WordPress laden
$wp_load = null;
$dir = __DIR__;
for ($i = 0; $i < 6; $i++) {
    if (file_exists($dir . '/wp-load.php')) {
        $wp_load = $dir . '/wp-load.php';
        break;
    }
    $dir = dirname($dir);
}
if ($wp_load) require_once($wp_load);

// 2. Dompdf laden (Pfad korrigiert auf deinen neuen Ordner 'dompdf')
$dompdf_path = dirname(__DIR__) . '/dompdf/autoload.inc.php'; 

if (file_exists($dompdf_path)) {
    require_once $dompdf_path;
} else {
    die('Fehler: autoload.inc.php nicht gefunden unter: ' . $dompdf_path);
}

use Dompdf\Dompdf;
use Dompdf\Options;

// 3. Daten aus deinem Formular empfangen
// Diese Namen (format, seiten, etc.) müssen zu deinem HTML passen!
// Daten aus dem Formular empfangen (Namen müssen zu deinem HTML passen)
$format        = $_POST['format'] ?? '';
$grammatur     = $_POST['grammatur'] ?? '';
$seitendruck   = $_POST['seitendruck'] ?? '';
$seiten        = $_POST['seiten'] ?? '';
$farbseiten    = $_POST['farbseiten'] ?? '';
$exemplare     = $_POST['exemplare'] ?? '1';
$mwst_typ      = $_POST['mwst'] ?? '';

$bindungsart   = $_POST['bindungsart'] ?? '';
$prägung       = $_POST['prägung'] ?? '';
$prägungsfarbe = $_POST['prägungsfarbe'] ?? '';

$versandart    = $_POST['versandart'] ?? 'Standard';
$zahlungsart   = $_POST['zahlungsart'] ?? 'Vorkasse mit Überweisung';

$einzelpreis   = $_POST['pdf_einzelpreis'] ?? '0,00';
$gesamtpreis   = $_POST['pdf_gesamtpreis'] ?? '0,00';
$versandkosten = $_POST['versandkosten'] ?? '0,00';

// 4. PDF erstellen
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Das Design angelehnt an deine Vorlage
$html = "
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header { width: 100%; margin-bottom: 20px; }
        .logo-box { text-align: right; }
        .logo { width: 50px; }
        .address-line { font-size: 9px; margin-bottom: 20px; }
        
        .title { font-size: 16px; font-weight: bold; margin-top: 10px; }
        .subtitle { margin-bottom: 20px; }
        
        .section-title { font-weight: bold; font-size: 12px; margin-top: 15px; border-bottom: 1px solid #000; width: 60px; }
        .data-table { width: 100%; margin-top: 5px; border-collapse: collapse; }
        .data-table td { padding: 2px 0; vertical-align: top; }
        .label { width: 200px; }
        
        .price-table { width: 100%; margin-top: 20px; }
        .price-label { width: 200px; }
        .total-row { font-weight: bold; font-size: 12px; }
        
        .footer-text { margin-top: 30px; font-size: 10px; }
    </style>
</head>
<body>
    <div class='header'>
        <table style='width: 100%;'>
            <tr>
            <img src='/templates/img/logo.png' class='logo'>
                <td class='address-line'>Drucktheke · Schubertstraße 14 · 01307 Dresden</td>
                <td class='logo-box'>
                    
                    <br>" . date('d.m.Y') . "
                </td>
            </tr>
        </table>
    </div>

    <div class='title'>Online Kalkulation</div>
    <div class='subtitle'>Wir bedanken uns für Ihr Interesse, anbei erhalten Sie Ihre Online Kalkulation:</div>

    <div class='section-title'>Druck:</div>
    <table class='data-table'>
        <tr><td class='label'>Format:</td><td>$format</td></tr>
        <tr><td class='label'>Grammatur:</td><td>$grammatur</td></tr>
        <tr><td class='label'>Seitendruck:</td><td>$seitendruck</td></tr>
        <tr><td class='label'>Seiten:</td><td>$seiten Seiten, davon $farbseiten Farbseiten</td></tr>
        <tr><td class='label'>Anzahl der Exemplare:</td><td>$exemplare</td></tr>
        <tr><td class='label'>MwSt.::</td><td>$mwst_typ</td></tr>
    </table>

    <div class='section-title'>Bindung:</div>
    <table class='data-table'>
        <tr><td class='label'>Bindungsart:</td><td>$bindungsart</td></tr>
        <tr><td class='label'>Prägung:</td><td>$prägung</td></tr>
        <tr><td class='label'>Prägungsfarbe:</td><td>$prägungsfarbe</td></tr>
    </table>

    <div class='section-title'>Lieferung:</div>
    <table class='data-table'>
        <tr><td class='label'>Unsere Fertigungszeiten:</td><td>Mo. - Fr. 8.30 Uhr - 19.00 Uhr</td></tr>
        <tr><td class='label'>Versandart:</td><td>$versandart</td></tr>
        <tr><td class='label'>Zahlungsart:</td><td>$zahlungsart</td></tr>
    </table>

    <table class='price-table'>
        <tr><td class='price-label'>Einzelpreis:</td><td>$einzelpreis €</td></tr>
        <tr><td class='price-label'>Summe:</td><td>$einzelpreis €</td></tr>
        <tr><td class='price-label'>zzgl. Versandkosten:</td><td>$versandkosten €</td></tr>
        <tr class='total-row'><td class='price-label'>Gesamtpreis:</td><td>$gesamtpreis €</td></tr>
    </table>

    <div class='footer-text'>
        Die Preise beinhalten die gesetzliche Mehrwertsteuer für den Druck von Büchern / Broschüren: 7% für Privatpersonen und 19% für Firmen.<br>
        Es gelten unsere AGB in der jeweils gültigen Fassung.<br><br>
        Dies ist ein unverbindliches Angebot, die Preise erlangen mit der Zusendung der Auftragsbestätigung Ihre Gültigkeit.<br><br>
        Bei Fragen stehen wir Ihnen gern unter der Rufnummer 0351 / 41 37 26 62 zur Verfügung.<br><br>
        Mit freundlichen Grüßen<br><br>
        Ihr Team von Drucktheke.de
    </div>
</body>
</html>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// PDF anzeigen
$dompdf->stream("Angebot_Drucktheke.pdf", ["Attachment" => false]);