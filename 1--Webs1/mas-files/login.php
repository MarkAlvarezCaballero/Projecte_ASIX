<!DOCTYPE html>
<html lang="es">

<!--Metadades, estils i font-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/style.css"/>
    <link rel="icon" type="image/x-icon" href="/imagenes/mas.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Iniciar sessió</title>
</head>


<body class="body_login">
    
    <!--Div per crear les rodones flotants-->
    <div class="background">
        <div class="shape3"></div>
        <div class="shape4"></div>
    </div>
    


    
    <!--action="validacioLogin.php" defineix la pàgina on es processaran les dades del formulari.-->
    <form method="POST" id="formulari" action="validacioLogin.php">
        <!--Logo professor-->
        <img src="imagenes/fotoLogin.png" alt="professor">

        <!--Titol-->
        <h3>Iniciar sessió</h3>
       
        <!--Inputs formulari (Nom complet, email, telèfon)-->
        <input type="email" name="usuari" id="usuari" placeholder="Introdueix el teu usuari"/>
        <input type="password" name="password" id="password" placeholder="Introdueix la contrasenya"/>
            <i class="bi bi-eye-slash" id="togglePassword"></i>

        <!-- Mostrar missatges d'error -->
        <div id="error-credenciales" class="error-message">
            <?php if (isset($_GET['errors'])) {
                $error_messages = json_decode(urldecode($_GET['errors']), true);
                if (!empty(array_filter($error_messages))) {
                    foreach ($error_messages as $error) {
                        echo $error;
                    }
                }
            } //Mostra els missatges de error si hi ha ?>
        </div>

        
        
        <input type="submit" name="login_button" value="Iniciar sessió" onclick="return validateForm()">
        <!--Validació del Formulari: Abans d'enviar el formulari, es crida la funció validateForm() definida en el fitxer validarLogin.js per assegurar-se que les dades són correctes.-->
        <script src="validarLogin.js"></script>

        <!--Mostrar/Amagar la Contrasenya: Quan l'usuari fa clic a la icona amb l'ID togglePassword, el codi canvia el tipus de l'input de contrasenya entre password i text, permetent a l'usuari veure o amagar la contrasenya que està introduint.-->
        <script>
            const togglePassword = document.querySelector("#togglePassword");
            const password = document.querySelector("#password");
            togglePassword.addEventListener("click", function() {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                this.classList.toggle("bi-eye");
            });
        </script>
    </form>
    
</body>
</html>