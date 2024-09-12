function validateForm() {
    // Recollida de dades
    const usuario = document.getElementsByName("usuari")[0].value;
    const contrasenya = document.getElementsByName("password")[0].value;

    // Selecciona l'element on es mostraran els missatges d'error.
    const errorCreds = document.getElementById("error-credenciales");
    // Selecciona l'element del formulari.
    const formulari = document.getElementById('formulari')
    // Inicialitza una variable error per fer el seguiment dels errors de validació.
    let error = false;

    formulari.addEventListener("submit", function(event) {
        // Evita que el formulari s'enviï automàticament quan es prem el botó de submit.
        event.preventDefault();

        //Treure els missatges d'error
        errorCreds.innerHTML = "";

        // Validació dels Camps del Formulari
        if (usuario === "") {
            errorCreds.innerHTML += "Correu electrònic no pot estar buit.<br>";
            error = true;
        }

        // Regex per comprovar el correu
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(usuario) && usuario !== "") {
            errorCreds.innerHTML += "Format de correu electrònic incorrecte.<br>";
            error = true;
        }

        if (contrasenya === "") {
            errorCreds.innerHTML += "Contrasenya no pot estar buida.<br>";
            error = true;
        }

        if (!error) {
            formulari.submit();
        }
    })
}