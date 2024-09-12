<?php
// Inclou el fitxer getNomTipusTitol.php que probablement conté les llistes de tipus i noms de títols.
include '../comu/getNomTipusTitol.php';

// Obtenir codi validació
$codiValidacio = $_GET['codi_validacio'];

// Si hi ha errors per GET, crea la variable per desprer mostrar els errors
if (isset($_GET['errors'])) $error_messages = json_decode(urldecode($_GET['errors']), true);

// Connexió a la base de dades
try {
    require_once '../comu/connexio.php';

    if (isset($_GET['codi_validacio'])) {
        // Obtenim el nom,cognoms,email i telefon del professor assignat al codi de validacio que s'ha introduit
        $select = $connexio->prepare("SELECT nom,cognom1,cognom2,email,telefon FROM professors WHERE codi_validacio = :codi_validacio");
        $select->execute(array(':codi_validacio' => $codiValidacio));
        $results = $select->fetch(PDO::FETCH_ASSOC);

        if (empty($results)) {
            header("Location: /errorCodi");
        } else {
            $nom = $results['nom'];
            $cog1 = $results['cognom1'];
            $cog2 = $results['cognom2'];
            $email = $results['email'];
            $telefon = $results['telefon'];
        }
    } else {
        header("Location: /errorCodi");
        exit;
    }
} 

// Si hi ha algun error en la connexio amb la base de dades mostrar missatge d'error
catch(PDOException $e) {
    echo "Error en el select: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="cat">

<head>
    <!--Es defineixen les metadades, el títol de la pàgina i els enllaços als fulls d'estil i fonts-->
    <meta charset="UTF-8">
    <title>Alta Professorat</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="/imagenes/mas.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!--El JavaScript mostrarText permet mostrar un camp de text addicional si l'usuari selecciona "altres" en un desplegable.-->
    <script>
        function mostrarText(num) {
            const select = document.getElementById("nomTitol" + num);
            const inputText = document.getElementById("campAltres" + num);

            if (select.value === "altres") {
                inputText.style.display = "inline";
                select.className = "altres";
            } else {
                inputText.style.display = "none";
                select.className = "nomEstudi";
            }
        }
    </script>
</head>

<body>

    <!--Es defineix la estructura visual de la pàgina, incloent formes de fons per estilitzar la pàgina. Son les pilotes flotant-->
    <div class="background">
        <div class="shape13"></div>
        <div class="shape14"></div>
    </div>

    <!--El formulari s'envia mitjançant el mètode POST al fitxer validarProfe.php i permet la càrrega d'arxius (enctype="multipart/form-data").-->
    <!--Hi han dades que s'autocompleten mitjançant la base de dades (codi php que hi ha a dalt)Hi han d'altres que ha de completar-->
    <!-- A sota de cada camp s'inclou una linea de codi php per si ja ha intentat introduir les dades academiques erroniament, es mostra el codi a sota del camp corresponent -->
    <form id="scrollable-content" method="POST" action="validarProfe.php" enctype="multipart/form-data">
        <input class="input"  
                type="text" 
                style="display: none;" 
                name="codiValidacio" 
                value="<?php echo $codiValidacio; ?>" 
                readonly/>

        <h2 class="seccion1">Secció 1: Dades Personals</h2>

        <input class="input"  type="text" 
                placeholder="DNI" 
                title="Introdueix el DNI" 
                name="dni" 
                pattern="[0-9]{8}[A-Z]" 
                required>

        <?php if (!empty($error_messages['dni'])) { echo $error_messages['dni']; } ?>

        <input  class="input"  
                type="text" 
                title="Introdueix el nom" 
                name="nom" 
                value="<?php if (isset($nom)) echo $nom; ?>" 
                readonly/>

        <?php if (!empty($error_messages['nom'])) { echo $error_messages['nom']; } ?>

        <input  class="input"
                type="text" 
                title="Introdueix primer cognom" 
                name="cog1" 
                value="<?php if (isset($cog1)) echo $cog1; ?>" 
                readonly>

        <?php if (!empty($error_messages['cognom1'])) { echo $error_messages['cognom1']; } ?>

        <input  class="input"
                type="text" 
                title="Introdueix segon cognom" 
                name="cog2" 
                value="<?php if (isset($cog2)) echo $cog2; ?>" 
                readonly>

        <?php if (!empty($error_messages['cognom2'])) { echo $error_messages['cognom2']; } ?>

        <input  class="input"
                type="date" 
                title="Selecciona la data de naixement" 
                name="dataNaixement" 
                required>

        <?php if (!empty($error_messages['dataNaixement'])) { echo $error_messages['dataNaixement']; } ?>
        <input  class="input"
                type="file" 
                accept="image/png" 
                name="foto" 
                required>
        <?php if (!empty($error_messages['foto'])) { echo $error_messages['foto']; } ?>


        <h2 class="secciones2y3">Secció 2: Dades de Contacte</h2>
        <input  class="input"
                type="email" 
                title="Introdueix email" 
                name="email" 
                value="<?php if (isset($email)) echo $email; ?>" 
                readonly>
        <?php if (!empty($error_messages['email'])) { echo $error_messages['email']; } ?>
        <input  class="input"
                type="tel" 
                title="Introdueix telèfon" 
                name="telefon" 
                value="<?php if (isset($telefon)) echo $telefon; ?>" 
                readonly>
        <?php if (!empty($error_messages['telefon'])) { echo $error_messages['telefon']; } ?>

<!----------------------------------------------------------------------------------------->

        <h2 class="secciones2y3">Secció 3: Dades Acadèmiques</h2>
        
        <div class="divAca">
            <h3 class="h3">Titol acadèmic 1</h3>
            <label for="tipusTitol1">Tipus d'estudi:</label>
            <select id="tipusTitol1" 
                    class="tipusTitol1" 
                    name="tipusTitol1" 
                    required>
                <option value="selecciona" 
                        selected>Selecciona tipus d'estudi</option>
                <?php foreach ($tipusTitols as $tipus) {echo "<option value='$tipus'>$tipus</option>";} ?> <!-- Dona a escollir tantes opcions com tipus de estudi hi hagi introduits a la BD -->
            </select>
            <?php if (!empty($error_messages['tipusTitol1'])) { echo $error_messages['tipusTitol1']; } ?>
            <label for="nomTitol1">Nom del estudi:</label>
            <br>
            <select id="nomTitol1" 
                    class="nomTitol1" 
                    name="nomTitol1" 
                    required onchange="mostrarText(1)">
                <option value="selecciona" 
                        selected>Selecciona nom del estudi</option>
                <?php foreach ($nomTitols as $nom) {echo "<option value='$nom'>$nom</option>";} ?> <!-- Dona a escollir tantes opcions com noms diferents per als titols hi hagi introduits a la BD -->
                <option value="altres">Altres...</option>
                <input  class="input"
                        type="text" 
                        id="campAltres1" 
                        name="campAltres1" 
                        style="display: none;">
            </select>
            <?php if (!empty($error_messages['nomTitol1'])) { echo $error_messages['nomTitol1']; } ?>
        </div>

        <br>    
        <!----------------------------Separació entre divs------------------------------------>
        
        <div class="divAca">
            <h3>Titol acadèmic 2 (opcional)</h3>
            <label for="tipusTitol2">Tipus d'estudi:</label>
            <select id="tipusTitol2" 
                    class="tipusTitol2" 
                    name="tipusTitol2">
                <option value="selecciona">Selecciona tipus d'estudi</option>
                <?php foreach ($tipusTitols as $tipus) {echo "<option value='$tipus'>$tipus</option>";} ?>
            </select>
            <?php if (!empty($error_messages['tipusTitol2'])) { echo $error_messages['tipusTitol2']; } ?>
            <label for="nomTitol2">Nom del estudi:</label>
            <select id="nomTitol2" 
                    class="nomTitol2" 
                    name="nomTitol2" 
                    onchange="mostrarText(2)">
                <option value="selecciona">Selecciona nom del estudi</option>
                <?php foreach ($nomTitols as $nom) {echo "<option value='$nom'>$nom</option>";} ?>
                <option value="altres">Altres...</option>
                <input  type="text" 
                        id="campAltres2" 
                        name="campAltres2" 
                        style="display: none;">
            </select>
            <?php if (!empty($error_messages['nomTitol2'])) { echo $error_messages['nomTitol2']; } ?>
        </div>
    <!----------------------------------------------------------------------------------------->
        <label class="mycheckbox">
            <input type="checkbox" name="acord" value="confirmat" required>
            Estic d'acord amb l'<a href="https://maspr.sapalomera.cat/acord">acord de privacitat</a>
            <span></span>
        </label>
<!----------------------------------------------------------------------------------------->
        <input type="submit" value="Enviar dades">
    </form>
</body>
</html>
