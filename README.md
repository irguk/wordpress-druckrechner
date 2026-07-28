# Druckrechner – WordPress Plugin

Ein individuelles WordPress-Plugin zur Echtzeit-Berechnung von Druckkosten und zur dynamischen Produkt-Vorschau. Das Plugin ermöglicht Benutzern die Konfiguration von Druckaufträgen (z. B. Bindung, Seitenzahl, Farbedruck, CD-Optionen) inklusive dynamischer Preisermittlung und PDF-Generierung.

---

## 🚀 Funktionen

* **Dynamischer Druckrechner:** Asynchrone Preisberechnung basierend auf Seitenzahl, Farbseiten, Format, Grammatur und Bindungsart.
* **Live-Vorschau (Preview-System):** Dynamisches Laden der Produkt- und Einbandbilder über einen eigenen Bild-Server (`previewimg.php`).
* **PDF-Generierung:** Automatische Erstellung von Zusammenfassungen/Angeboten als PDF-Datei via `dompdf`.
* **Zusatzoptionen:** Konfiguration von Zusatzleistungen wie CD-Beilagen, Hüllen und Direktdruck.
* **Admin-Verwaltung:** Admin-Bereich zur Verwaltung von Preisen, Formaten und Einstellungen.

---

## 📁 Projektstruktur

```text
druckrechner/
├── admin/                  # Admin-Bereich & Einstellungen
├── assets/                 # CSS, JavaScript und Statische Ressourcen
├── dompdf/                 # Dompdf-Bibliothek für die PDF-Generierung
├── includes/               # Backend-Logik & Datenbank-Abfragen
├── templates/              # HTML/PHP-Template-Bausteine
│   ├── img/                # Produkt- und Vorschau-Bilder
│   ├── form-section.php    # Formular-Abschnitte
│   ├── preview-section.php # Live-Vorschaubereich
│   ├── pdf.php             # PDF-Erstellungsskript
│   ├── step-2.php          # Schritt 2 der Konfiguration
│   └── step-3.php          # Schritt 3 der Konfiguration
├── druckrechner.php        # Haupt-Plugin-Datei (Plugin Header & Hooks)
├── index.php               # Sicherheits-Fallback
├── previewimg.php          # Dynamic Image Delivery Handler
└── README.md               # Projektdokumentation
