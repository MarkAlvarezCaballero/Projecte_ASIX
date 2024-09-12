<?php

// Aquest codi s'utilitza per establir una connexió segura i gestionada a una base de dades MySQL utilitzant PDO. La connexió es realitza dins d'un bloc try per gestionar possibles errors amb un bloc catch, que captura i mostra els missatges d'error, i un bloc finally per assegurar-se que la connexió es tanqui adequadament al final del procés.
try {
    // mysql:host=localhost;dbname=webs: Defineix el DSN (Data Source Name), que inclou el tipus de base de dades (MySQL), el nom del servidor (localhost), i el nom de la base de dades (webs).
    // "mas": Nom d'usuari per connectar-se a la base de dades.
    // 'F#GHjfb3%c3B&39i$PMJ3': Contrasenya per a l'usuari de la base de dades.
    $connexio = new PDO("mysql:host=localhost;dbname=webs", "mas", 'F#GHjfb3%c3B&39i$PMJ3');
}
catch (PDOException $e){
    echo $e->getMessage();
    exit;
}
finally {
    $DBH = null;
}