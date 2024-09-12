<?php

// Aquest script PHP (codiVerificacio.php) s'encarrega de validar el codi de validació introduït pel professor i redirigir-lo a la pàgina adequada segons el resultat de la validació. A continuació es descriu detalladament cada part del codi:

try {
    // Es carrega el fitxer de connexió a la base de dades (connexio.php).  
    require_once '../comu/connexio.php';

    // Es prepara una consulta SQL per obtenir el codi_validacio i el dni del professor que coincideixi amb el codi de validació introduït (:codiValidacio).
    // :codiValidacio s'obté de les dades POST del formulari ($_POST['codi_validacio']).
    $select = $connexio->prepare("SELECT codi_validacio,dni FROM professors WHERE codi_validacio = :codiValidacio");
    $select->execute(array(':codiValidacio' => $_POST['codi_validacio']));
    $results = $select->fetch(PDO::FETCH_ASSOC);
    $codiValidacio = $results['codi_validacio'];

    // Depenent dels resultats redirigeix a la pagina adient
    // Si no es troben resultats (és a dir, no hi ha cap professor amb el codi de validació introduït), es redirigeix a errorCodi.html, que informa que el codi de validació és incorrecte.
    if (empty($results)) {
        header("Location: /errorCodi");
    } 
    // elseif (!empty($results['dni'])): Si el codi de validació és vàlid però el camp dni no està buit (indicant que el professor ja està registrat), es redirigeix a errorRegistrat.html, que informa que el professor ja està registrat.
    elseif (!empty($results['dni'])) {
        header("Location: /errorRegistrat");
    } 
    // else: Si el codi de validació és vàlid i el camp dni està buit (indicant que el professor no està registrat), es redirigeix a dadesAcademiques.php amb el codi de validació passat com a paràmetre GET (?codi_validacio=$codiValidacio), on el professor pot completar el seu registre.
    else {
        header("Location: /profe/dadesAcademiques.php?codi_validacio=$codiValidacio");
    }
    exit;
} 
// Si es produeix un error en la consulta a la base de dades, es captura l'excepció PDOException i es mostra un missatge d'error amb el contingut de l'excepció.
catch(PDOException $e) {
    echo "Error en el select: " . $e->getMessage();
}
