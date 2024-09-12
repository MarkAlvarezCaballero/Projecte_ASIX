<?php

// Inicialització de l'Array de Missatges d'Error
// Aquest array s'utilitza per emmagatzemar els missatges d'error relacionats amb l'usuari i la contrasenya.
$error_messages = array(
    'usuari' => '',
    'password' => '',
);

try {
    //Connexió a la Base de Dades
    require_once './comu/connexio.php';

    // Comprova si la sol·licitud s'ha fet mitjançant el mètode POST, assegurant-se que el formulari ha estat enviat.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Es recullen les dades de l'usuari i la contrasenya del formulari.
        $usuari = $_POST['usuari'];
        $contrasenya = $_POST['password'];

        // Es valida que els camps no estiguin buits. Si algun camp està buit, es genera un missatge d'error corresponent.
        if (empty($usuari)) {
            $error_messages['usuari'] = "Usuari no pot estar buit" . "<br>";
        }
        if (empty($contrasenya)) {
            $error_messages['password'] = "La contrasenya no pot estar buida" . "<br>";
        }

        //Es valida que l'usuari tingui un format d'email vàlid. Si no és així, es genera un missatge d'error.
        if (!filter_var($usuari, FILTER_VALIDATE_EMAIL) && !empty($usuari)) {
            $error_messages['usuari'] = "Introdueix un format d'usuari valid" . "<br>";
        }

        // Si no hi ha errors en la validació dels camps (empty(array_filter($error_messages))), es prepara una consulta SQL per obtenir l'ID de l'usuari amb les credencials proporcionades.


        if (empty(array_filter($error_messages))) {

            // Obtenim la id del usuari i contrasenya introduits al formulari
            $select = $connexio->prepare("SELECT id FROM usuaris WHERE usuari = :usuari AND password = :password");
            
            // La contrasenya es xifra amb SHA-256 abans de la comparació.
            $select->execute(array( ':usuari' => $usuari, ':password' => hash('sha256',$contrasenya)));
            $idUsuari = $select->fetch(PDO::FETCH_COLUMN,0);

            
            // Si es troba un usuari amb aquestes credencials, es redirigeix l'usuari a la pàgina corresponent segons el seu ID.
            if (!empty($idUsuari)) {
                if ($idUsuari == 1) {
                    header("Location: /admin");
                    exit;
                } elseif ($idUsuari == 2) {
                    header("Location: /conserge");
                    exit;
                }
            } 
            
            // Si les credencials són incorrectes, es genera un missatge d'error.
            else {
                $error_messages['usuari'] = "Usuari o contrasenya incorrectes" . "<br>";
            }
        }

        //     Si hi ha errors, aquests es codifiquen i s'envien a la pàgina de login (login.php) com a paràmetres GET.
        // La pàgina de login podrà mostrar aquests missatges d'error a l'usuari.
        $error_messages_encoded = urlencode(json_encode($error_messages));
        header("Location: login.php?errors=$error_messages_encoded");
    }
} 

// Si hi ha algun error durant la connexió o l'execució de la consulta SQL, es captura l'excepció PDOException i es mostra un missatge d'error.
catch(PDOException $e) {
    echo "Error en el select: " . $e->getMessage();
}