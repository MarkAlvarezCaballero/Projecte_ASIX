<?php

try {
    require_once '../comu/connexio.php';

    // Obtenim tots els profes
    $selectProfes = $connexio->query("SELECT * FROM professors");
    $profes = $selectProfes->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error en el select: " . $e->getMessage();
    exit;
} ?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="/imagenes/mas.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Administrador</title>
</head>
<body class="admin">
    <h1 class="h1_professors">Professors</h1>
    <table>
        <?php
        $i = 0;
        foreach ($profes as $profe) {
            // Si ja hi han 3 profes a la fila, crea un altre
            if ($i == 0) echo "<tr>"; elseif ($i%3 == 0) echo "</tr><tr>";

            $idProfe = $profe['id'];
            $nom = $profe['nom'];
            $cognom1 = $profe['cognom1'];
            $cognom2 = $profe['cognom2'];
            $email = $profe['email'];
            $telefon = $profe['telefon'];

            if (!empty($profe['dni'])) $dni = $profe['dni'];
            if (!empty($profe['data_naixement'])) $dataNaixement = $profe['data_naixement'];

            // Si el profe no te foto, se li assigna una per defecte
            if (!empty($profe['foto'])) $rutaFoto = substr($profe['foto'], 12); else $rutaFoto = "/profe/fotos/no-foto.png";

            echo "<td>";
            echo "<div class='divFoto'><img class='foto' alt='Foto $nom $cognom1 $cognom2' src='$rutaFoto'></div>";
            echo "<p><b>Nom: </b>" . "$nom</p>";
            echo "<p><b>1r cognom: </b>" . "$cognom1</p>";
            echo "<p><b>2n cognom: </b>" . "$cognom2</p>";
            echo "<p><b>Correu electronic: </b>" . "$email</p>";
            echo "<p><b>Telefón: </b>" . "$telefon</p>";

            if (!isset($dni) && !isset($dataNaixement)) {
                echo "<p class='faltaAlta'>Falta continuar alta</p>";
            } else {
                echo "<p><b>DNI:</b> " . "$dni</p>";
                echo "<p><b>Data Naixement:</b> " . "$dataNaixement</p>";
                echo "<p><b>Títols:</b></p>";

                // Obtenim els noms dels titols que té el professor
                $select = $connexio->query("SELECT CONCAT(titols_academics.tipus_titol,' ',titols_academics.nom_titol) AS 'Titol' FROM ((titols_professors INNER JOIN professors ON titols_professors.professor_id = professors.id) INNER JOIN titols_academics ON titols_professors.titol_id = titols_academics.id) WHERE professor_id = $idProfe");
                $titols = $select->fetchAll(PDO::FETCH_COLUMN);

                // Mostra els titols en una llista desordenada
                echo "<ul>";
                foreach ($titols as $titol) {echo "<li>$titol</li>";}
                echo "</ul>";
            }
            echo "</td>";
            $i++;
        }
        echo "</tr>";
        ?>
    </table>
</body>
</html>
