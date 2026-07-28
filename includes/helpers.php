<?php
function druckrechner_berechne_preis($data) {
    $preis = 10;

    if ($data['format'] === 'A5') $preis -= 2;
    if ($data['grammatur'] === '120') $preis += 3;
    if ($data['seitendruck'] === 'beidseitig') $preis += 5;

    $preis += (int)$data['seiten'] * 0.05;
    $preis += (int)$data['farbseiten'] * 0.10;
    $preis *= (int)$data['exemplare'];

    if ($data['steuer'] === 'Firma') {
        $preis *= 1.19;
    } elseif ($data['steuer'] === 'Privat') {
        $preis *= 1.07;
    }

    return $preis;
}

