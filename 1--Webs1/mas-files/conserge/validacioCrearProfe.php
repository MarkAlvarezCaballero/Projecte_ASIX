<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../extensions/PHPMailer/PHPMailer.php';
require '../extensions/PHPMailer/Exception.php';
require '../extensions/PHPMailer/SMTP.php';

// Es crea un nou objecte PHPMailer.
$mail = new PHPMailer(true);

try {

    // Connexió a la Base de Dades: Es carrega el fitxer de connexió a la base de dades.
    require_once '../comu/connexio.php';

    // Comprovem que tots el camps segueixen les següents expressions regulars.
    // nom, cog1, cog2:Comprova que comencin amb una lletra majúscula i segueixin amb lletres minúscules.
    // email: Comprova que tingui un format vàlid de correu electrònic.
    // tel: Comprova que tingui exactament 9 dígits.

    if (preg_match("/^[A-Z][a-záéíóúñü]{0,39}$/",$_POST['nom']) &&
        preg_match("/^[A-Z][a-záéíóúñü]{0,39}$/",$_POST['cog1']) &&
        preg_match("/^[A-Z][a-záéíóúñü]{0,39}$/",$_POST['cog2']) &&
        preg_match("/^[\w.-]+@([\w-]+\.)+[\w-]+$/",$_POST['email']) &&
        preg_match("/^[0-9]{9}$/",$_POST['tel'])) {

        // Insertem el profesor a la taula pertinent
        $insert = $connexio->prepare("INSERT INTO professors (nom,cognom1,cognom2,email,telefon) VALUES (:nom,:cog1,:cog2,:mail,:tel)");
        $insert->execute(array(
            'nom' => $_POST['nom'],
            'cog1' => $_POST['cog1'],
            'cog2' => $_POST['cog2'],
            'mail' => $_POST['email'],
            'tel' => $_POST['tel'],
        ));
    } 
    
    else {
        // Si alguna validació falla, es llença una excepció amb el missatge "Datos erroneos".
        throw new Exception("Datos erroneos");
    }

    // Obtenim el codi de validacio autogenerat
    $select = $connexio->prepare("SELECT codi_validacio FROM professors WHERE email = :email");
    $select->execute(array(':email' => $_POST['email']));
    $codiValidacio = $select->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    header("Location: /errorRepetit");
    exit;
} catch (Exception $e) {
    header("Location: /errorDades");
    exit;
} 

finally {
    // Si s'ha obtingut un codi de validació ($codiValidacio no està buit), s'envia un correu electrònic al professor amb el codi de validació i un enllaç per completar el procés de registre.

    // Configuració del correu:
        // isSMTP(): Utilitza el protocol SMTP per enviar el correu.
        // Host: Defineix el servidor SMTP (en aquest cas, Gmail).
        // SMTPAuth: Activa l'autenticació SMTP.
        // Username i Password: Credencials del compte de correu electrònic.
        // Port: Port utilitzat per SMTP (587 per TLS).
        // setFrom(): Defineix l'adreça de correu i el nom del remitent.
        // addAddress(): Defineix l'adreça de correu del destinatari.
        // Subject: Defineix l'assumpte del correu.
        // msgHTML(): Defineix el contingut HTML del correu, que inclou el codi de validació i un enllaç al formulari de validació.

    if (!empty($codiValidacio)) {
        $mail->isSMTP();
        $mail->Host         = 'smtp.gmail.com';
        $mail->SMTPAuth     = true;
        $mail->Username     = 'asix2-m14-mas@sapalomera.cat';
        $mail->Password     = ",t-nXRu2h~}MMc6";
        $mail->Port         = 587;
        $mail->setFrom('asix2-m14-mas@sapalomera.cat','MAS');
        $mail->addAddress($_POST['email']);
        $mail->Subject      = 'Process d\'alta';
        $mail->msgHTML( "<p>Bones " . $_POST['nom'] . ' ' . $_POST['cog1'] . " " . $_POST['cog2'] . ". Aquest és un correu generat automaticament per continuar amb el procès d'alta.</p>
                        <p>Introdueix el codi de validacio (" . $codiValidacio['codi_validacio'] . ") al següent <a href='https://maspr.sapalomera.cat/profe'>formulari</a></p>");
        $mail->send();
    }

    // Un cop enviat el correu, es redirigeix el conserge a dadesCorrectes.html, confirmant que el procés ha estat completat correctament.
    header("Location: /conserge/dadesCorrectes");
}
