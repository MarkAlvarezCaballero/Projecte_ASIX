<?php
// S'inclou el fitxer getNomTipusTitol.php que conté llistes de tipus i noms de títols.
include '../comu/getNomTipusTitol.php';

// Funcio per validar si la data pasada per parametre es anterior a la data actual
function validarDataAbans($data): bool {
    $dataInici = strtotime(date('Y-m-d', strtotime($data) ) );
    $dataActual = strtotime(date('Y-m-d'));

    if ($dataInici < $dataActual) {
        return true;
    } return false;
}

// Funcio per comprovar si la data esta en el format correcte
function validarData($date, $format = 'Y-m-d'): bool {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Emmagatzema els missatges d'error per a cada camp.
$error_messages = array(
    'dni' => '',
    'nom' => '',
    'cognom1' => '',
    'cognom2' => '',
    'dataNaixement' => '',
    'foto' => '',
    'email' => '',
    'telefon' => '',
    'tipusTitol1' => '',
    'nomTitol1' => '',
    'tipusTitol2' => '',
    'nomTitol2' => '',
    'acord' => '',
);

// Variables de Control: insertNomTitol1 i insertNomTitol2 per determinar si s'han d'inserir nous noms de títols acadèmics.
// Codi de Validació: S'obté del formulari POST.
$insertNomTitol1 = false;
$insertNomTitol2 = false;
$codiValicacio = $_POST['codiValidacio'];


try {
    
    // Es carrega el fitxer de connexió a la base de dades (connexio.php).
    require_once "../comu/connexio.php";

    // Obté les dades del professor associades al codi de validació (nom,cognoms,email i telefon) passat per POST. 
    $select = $connexio->prepare("SELECT nom,cognom1,cognom2,email,telefon FROM professors WHERE codi_validacio = :codi_validacio");
    $select->execute(array(':codi_validacio' => $codiValicacio));
    $results = $select->fetch(PDO::FETCH_ASSOC);

    // Si no es troben resultats, redirigeix a errorCodi.html.
    if (empty($results)) {
        header("Location: /errorCodi");
    } 
    
    // Si es troben resultats, continua amb la validació dels camps.
    // Comprova per cada camp si no esta buit i si esta ben introduit (format,mida,etc...)
    else {
        // Comprova el format del DNI i que no estigui buit.
        if (!preg_match("/^[0-9]{8}[A-Z]$/",$_POST['dni'])){
            $error_messages['dni'] = "DNI incorrecte" . "<br>";
        } elseif (empty($_POST['dni'])) {
            $error_messages['dni'] = "DNI no pot estar buit" . "<br>";
        }

        // Comprova que coincideixin amb els valors a la base de dades i que no estiguin buits.
        if ($results['nom'] != $_POST['nom']) {
            $error_messages['nom'] = "El nom introduit no coincideix amb la BBDD" . "<br>";
        } elseif (empty($_POST['nom'])) {
            $error_messages['nom'] = "Nom no pot estar buit" . "<br>";
        }

        if ($results['cognom1'] != $_POST['cog1']) {
            $error_messages['cognom1'] = "El primer cognom introduit no coincideix amb la BBDD" . "<br>";
        } elseif (empty($_POST['cog1'])) {
            $error_messages['cognom1'] = "Primer cognom no pot estar buit" . "<br>";
        }

        if ($results['cognom2'] != $_POST['cog2']) {
            $error_messages['cognom2'] = "El segon cognom introduit no coincideix amb la BBDD" . "<br>";
        } elseif (empty($_POST['cog2'])) {
            $error_messages['cognom2'] = "Segon cognom no pot estar buit" . "<br>";
        }


        // Comprova el format i que la data sigui anterior a la data actual.
        if (!validarData($_POST['dataNaixement'])) {
            $error_messages['dataNaixement'] = "Format data de naixement incorrecte" . "<br>";
        } elseif (!validarDataAbans($_POST['dataNaixement'])) {
            $error_messages['dataNaixement'] = "Data naixement incorrecte" . "<br>";
        } elseif (empty($_POST['dataNaixement'])) {
            $error_messages['dataNaixement'] = "Data naixement no pot estar buida" . "<br>";
        }

        // Validació de la Foto: Comprova que s'hagi pujat una foto, que sigui PNG i que tingui una mida adequada.
        if (!isset($_FILES['foto'])) {
            $error_messages['foto'] = "No s'ha pujat cap foto" . "<br>";
        } elseif (exif_imagetype($_FILES['foto']['tmp_name']) != IMAGETYPE_PNG) {
            $error_messages['foto'] = "L'arxiu pujat no es un png";
        } elseif (filesize($_FILES['foto']['tmp_name']) <= 0) {
            $error_messages['foto'] = "La foto pujada no pot pesar menys de 0 B";
        }

        // Validació de l'Email i Telèfon: Comprova que coincideixin amb els valors a la base de dades i que no estiguin buits.
        if ($results['email'] != $_POST['email']) {
            $error_messages['email'] = "El email introduit no coincideix amb la BBDD" . "<br>";
        } elseif (empty($_POST['email'])) {
            $error_messages['email'] = "Email no pot estar buit" . "<br>";
        }

        if ($results['telefon'] != $_POST['telefon']) {
            $error_messages['telefon'] = "El telefon introduit no coincideix amb la BBDD" . "<br>";
        } elseif (empty($_POST['telefon'])) {
            $error_messages['telefon'] = "Telefon no pot estar buit" . "<br>";
        }

        // Validació dels Títols Acadèmics: Comprova que els títols acadèmics seleccionats siguin vàlids o que s'hagi introduït un nou nom de títol si l'opció és "altres". 
        if ($_POST['tipusTitol1'] === "selecciona") {
            $error_messages['tipusTitol1'] = "Has de seleccionar el tipus d'estudi" . "<br>";
        } elseif (!in_array($_POST['tipusTitol1'],$tipusTitols)) {
            $error_messages['tipusTitol1'] = "El tipus d'estudi no coincideix amb la llista de valors possibles" . "<br>";
        }

        if ($_POST['nomTitol1'] === "selecciona") {
            $error_messages['nomTitol1'] = "Has de seleccionar el nom del estudi" . "<br>";
        } elseif (!in_array($_POST['nomTitol1'],$nomTitols)) {
            if (empty($_POST['campAltres1']) && $_POST['nomTitol1'] != "altres") {
                $error_messages['nomTitol1'] = "El nom de l'estudi no coincideix amb la llista de valors possibles" . "<br>";
            } elseif (!empty($_POST['campAltres1']) && $_POST['nomTitol1'] === "altres") {
                $insertNomTitol1 = true;
            } elseif (empty($_POST['campAltres1'])) {
                $error_messages['nomTitol1'] = "Has d'introduir el nom del estudi" . "<br>";
            }
        }

        if ($_POST['nomTitol2'] != "selecciona") {
            if ($_POST['tipusTitol2'] === "selecciona") {
                $error_messages['tipusTitol2'] = "Has de seleccionar el tipus de estudi" . "<br>";
            } elseif (!in_array($_POST['tipusTitol2'], $tipusTitols)) {
                $error_messages['tipusTitol2'] = "El tipus d'estudi no coincideix amb la llista de valors possibles" . "<br>";
            }
        }

        if ($_POST['tipusTitol2'] != "selecciona") {
            if ($_POST['nomTitol2'] === "selecciona") {
                $error_messages['nomTitol2'] = "Has de seleccionar el nom del estudi" . "<br>";
            } elseif (!in_array($_POST['nomTitol2'], $nomTitols)) {
                if (empty($_POST['campAltres2']) && $_POST['nomTitol2'] != "altres") {
                    $error_messages['nomTitol2'] = "El nom del estudi no coincideix amb la llista de valors possibles" . "<br>";
                } elseif (!empty($_POST['campAltres2']) && $_POST['nomTitol2'] === "altres") {
                    $insertNomTitol2 = true;
                } elseif (empty($_POST['campAltres2'])) {
                    $error_messages['nomTitol2'] = "Has d'introduir el nom del estudi" . "<br>";
                }
            }
        }

        // Acceptació de l'Acord de Privacitat: Comprova que s'hagi acceptat l'acord de privacitat.
        if (!filter_has_var(INPUT_POST,'acord')) {
            $error_messages['acord'] = "Has d'acceptar l'acord de privacitat" . "<br>";
        }

        if (empty(array_filter($error_messages))) {
            // Obtenim l'extensio de la imatge i la seva nova ruta per després moure-la
            $extensio = image_type_to_extension(exif_imagetype($_FILES["foto"]['tmp_name']));
            $rutaFoto = __DIR__ . "/fotos/" . $_POST['dni'] . $extensio;
            move_uploaded_file($_FILES['foto']['tmp_name'],$rutaFoto);

            // Actualitzem els camps que abans estaben en NULL (dni,data_naixement,foto)
            $updateProfe = $connexio->prepare("UPDATE professors SET dni = :dni, data_naixement = :dataNaixement, foto = :rutaFoto WHERE codi_validacio = :codiValidacio AND email = :email");
            $updateProfe->execute(array(':dni' => $_POST['dni'],
                                        ':dataNaixement' => $_POST['dataNaixement'],
                                        ':rutaFoto' => $rutaFoto,
                                        ':codiValidacio' => $codiValicacio,
                                        ':email' => $_POST['email']));

                                                    
            $selectTitol = $connexio->prepare("SELECT id FROM titols_academics WHERE tipus_titol = :tipus AND nom_titol = :nom");

            // Comprova si fa falta introduir el nom del titol (perque el camp 'campAltres1' no esta buit i el camp 'nomTitol1' es 'altres') i posa la variable $nomTitol amb el valor que li pertoca
            if ($insertNomTitol1) $nomTitol = ucfirst(strtolower($_POST['campAltres1'])); else $nomTitol = $_POST['nomTitol1'];

            // Obtenim la id del titol buscant pel nom i el tipus
            $selectTitol->execute(array(':tipus' => $_POST['tipusTitol1'], ':nom' => $nomTitol));
            $titol = $selectTitol->fetch(PDO::FETCH_COLUMN,0);

            // Si no retorna cap titol l'introduiex a la tabla pertinent
            if (empty($titol)) {
                $insertNomTitol = $connexio->prepare("INSERT INTO titols_academics (tipus_titol,nom_titol) VALUES (:tipus,:nom)");
                $insertNomTitol->execute(array( ':tipus' => $_POST['tipusTitol1'], ':nom' => $nomTitol));
            }

            // Comprova si s'ha introduit el titol opcional
            if ($_POST['tipusTitol2'] != "selecciona" && $_POST['nomTitol2'] != "selecciona") {
                // Fa les mateixes comprovacions que l'anterior titol (si fa falta introduir el nom titol i si fa falta introduir el titol en si)
                $selectTitol = $connexio->prepare("SELECT id FROM titols_academics WHERE tipus_titol = :tipus AND nom_titol = :nom");

                if ($insertNomTitol2) $nomTitol = ucfirst(strtolower($_POST['campAltres2'])); else $nomTitol = $_POST['nomTitol2'];
                $selectTitol->execute(array(':tipus' => $_POST['tipusTitol2'], ':nom' => $nomTitol));
                $titol = $selectTitol->fetch(PDO::FETCH_COLUMN,0);

                if (empty($titol)) {
                    $insertNomTitol = $connexio->prepare("INSERT INTO titols_academics (tipus_titol,nom_titol) VALUES (:tipus,:nom)");
                    $insertNomTitol->execute(array( ':tipus' => $_POST['tipusTitol2'], ':nom' => $nomTitol));
                }
            }

            // Obtenim la id del profe mitjançant el codi de validacio
            $selectIdProfe = $connexio->query("SELECT id FROM professors WHERE codi_validacio = '$codiValicacio'");
            $idProfe = $selectIdProfe->fetch(PDO::FETCH_COLUMN,0);

            $tipusTitol = $_POST['tipusTitol1'];

            // Obtenim la id del titol mitjançant el tipus i el nom del titol
            $selectIdTitol = $connexio->query("SELECT id FROM titols_academics WHERE tipus_titol = '$tipusTitol' AND nom_titol = '$nomTitol'");
            $idTitol = $selectIdTitol->fetch(PDO::FETCH_COLUMN,0);

            // Introduim la id del professor i la id del titol a una llista
            $valors = [['professorId' => $idProfe, 'titolId' => $idTitol]];

            // Si s'ha introduit el titol opcional fa el mateix que el titol obligatori
            if ($_POST['tipusTitol2'] != "selecciona" && $_POST['nomTitol2'] != "selecciona") {
                $tipusTitol = $_POST['tipusTitol2'];
                $selectIdTitol = $connexio->query("SELECT id FROM titols_academics WHERE tipus_titol = '$tipusTitol' AND nom_titol = '$nomTitol'");
                $idTitol = $selectIdTitol->fetch(PDO::FETCH_COLUMN,0);
                $valors[] = ['professorId' => $idProfe, 'titolId' => $idTitol];
            }

            // Inserta els titol(s) al professor adient
            $insertTitolProfe = $connexio->prepare("INSERT INTO titols_professors (professor_id,titol_id) VALUES (:professorId,:titolId)");
            foreach ($valors as $valor) {$insertTitolProfe->execute($valor);}

            header("Location: /profe/dadesCorrectes");
            exit;
        }

        // Pasa l'array d'errors a la pagina adient per que pugin ser tractats
        $error_messages_encoded = urlencode(json_encode($error_messages));
        header("Location: dadesAcademiques.php?codi_validacio=$codiValicacio&errors=$error_messages_encoded");
    }

} catch(PDOException $e) {
    echo "Error en el select: " . $e->getMessage();
}