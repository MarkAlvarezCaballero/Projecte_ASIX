<?php
try {
    require_once 'connexio.php';

    // Obtenim la llista de valors del ENUM del camp 'tipus_titol'
    $selectTipus = $connexio->query("SHOW FIELDS FROM titols_academics LIKE 'tipus_titol';");
    $results = $selectTipus->fetch(PDO::FETCH_ASSOC);
    preg_match('#^enum\((.*?)\)$#ism', $results['Type'], $matches);
    $tipusTitols = str_getcsv($matches[1], ",", "'");

    // Obtenim tots els diferents noms de titols
    $selectNom = $connexio->query("SELECT DISTINCT nom_titol FROM titols_academics;");
    $nomTitols = $selectNom->fetchAll(PDO::FETCH_COLUMN, 0);

} catch(PDOException $e) {
    echo "Error en el select: " . $e->getMessage();
}