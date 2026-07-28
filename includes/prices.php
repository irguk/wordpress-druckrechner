<?php
/**
 * Korrigierte Preise.php für den Druckrechner
 * Alle Keys entsprechen den Werten in der Datenbank
 */

$_PRICES = array();
$_PRICES['book'] = array();

// 1. Druckpreise pro Seite (Staffelpreise)
// Bsp: Ab 4000 Seiten kostet eine S/W Seite nur noch 0.04€
$_PRICES['book']['page_print']['bw'] = array(
    0     => 0.06,
    500   => 0.05,
    1000  => 0.04,
    4000  => 0.035,
    30000 => 0.03
);

$_PRICES['book']['page_print']['cl'] = array(
    0     => 0.45,
    10    => 0.40,
    100   => 0.35,
    200   => 0.30,
    500   => 0.25,
    1000  => 0.18,
    15000 => 0.14,
    30000 => 0.12
);

// Aufpreise für Papiergrammatur (pro Seite)
$_PRICES['book']['page_print_add']['80g']  = 0.00;
$_PRICES['book']['page_print_add']['100g'] = 0.025;
$_PRICES['book']['page_print_add']['120g'] = 0.04;

// 2. Bindungspreise (Staffelpreise nach Seitenanzahl UND Menge)
// Struktur: ['bindung_key'][Min_Seiten][Min_Stückzahl] = Preis
$_PRICES['book']['bindings'] = array(
    
    'premium_lederoptik' => array(
        1   => array(1 => 13.00, 6 => 12.00, 10 => 11.00), // Bis 199 Seiten
        200 => array(1 => 14.50, 6 => 13.50, 10 => 13.00)  // Ab 200 Seiten
    ),

    'klemmbuch' => array(
        1   => array(1 => 9.00, 6 => 8.30, 10 => 7.50, 20 => 6.75)
    ),

    'premium_kaschmirleinenoptik' => array(
        1   => array(1 => 16.00),
        161 => array(1 => 17.50)
    ),

    'plastringbindung' => array(
        1   => array(1 => 2.40, 11 => 1.90, 51 => 1.60, 201 => 1.10),
        16  => array(1 => 2.75, 11 => 2.60, 51 => 2.20, 201 => 1.40),
        51  => array(1 => 3.60, 11 => 3.10, 51 => 2.40, 201 => 1.90),
        101 => array(1 => 3.90, 11 => 3.40, 51 => 2.90, 201 => 2.40)
    ),

    'drahtringbindung' => array(
        1   => array(1 => 2.90, 11 => 2.40, 51 => 1.90, 101 => 1.45),
        16  => array(1 => 3.40, 11 => 2.90, 51 => 2.40, 101 => 1.90),
        51  => array(1 => 3.90, 11 => 3.40, 51 => 2.90, 101 => 2.40),
        101 => array(1 => 4.40, 11 => 3.90, 51 => 3.55, 101 => 2.90)
    ),

    'faelzelband' => array(
        1   => array(1 => 4.75, 10 => 4.25, 50 => 4.00, 100 => 3.50, 200 => 2.70)
    ),

    'heissleimbindung' => array(
        1   => array(1 => 5.95, 10 => 5.35, 50 => 4.50, 100 => 3.50, 200 => 2.70)
    ),

    'kammbindung' => array(
        1   => array(1 => 3.50, 11 => 3.25, 51 => 3.00, 101 => 2.95, 201 => 2.70),
        100 => array(1 => 4.50, 11 => 4.25, 51 => 4.00, 101 => 3.75, 201 => 3.50)
    ),
    
    'ohne_bindung' => array(
        1   => array(1 => 0.00)
    )
);

// 3. Versandkosten
$_SHIPPING = array(
    'abholung' => array('label' => 'Abholung', 'price' => 0),
    'standard' => array('label' => 'Standardversand (1-2 Werktage)', 'price' => 6.90),
    'express'  => array('label' => 'Expressversand (nächster Werktag)', 'price' => 23.50)
);

// 4. Zahlungsarten
$_PAYMENT = array(
    'vorkasse' => array('label' => 'Vorkasse', 'price' => 0),
    'nachnahme' => array('label' => 'Nachnahme', 'price' => 7.00)
);