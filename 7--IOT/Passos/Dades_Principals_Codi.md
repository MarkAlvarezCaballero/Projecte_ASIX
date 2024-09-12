## Dades_Principals

<img src="../../.Images/IOT/Dades_Principals_Codi.PNG" alt="Dades_Personals2" style="width: 900px;"> <br><br>

### Que pasa quant fas click a Enrere?
Si dona clic a "Enrere" tornarà a Iniciar_Sessio

### Inicialització
Inicialitza una variable global anomenada "orden" buida.

Inicialitza una variable global anomenada "Correu" buida.

### Que pasa quant fas click a Següent?
Es construeix un URL amb les dades d'entrada que tenen: Nom, Cognoms i correu amb tipus de dades "Personals".
La variable creada abans anomenada "orden" posarem l'URL creada.

Posteriorment, crida a la funció "Envio" on substitueix els espais en blanc en l'URL pel codi "%20", després agafa la propietat de l'URL d'un component WEB1 amb el valor de la variable global "orden" i fa una sol·licitud HTTP GET a l'URL establerta.

### Emmagatzematge
Després de cridar al procediment "envio", guarda el valor ingressats de Correu en la BD TinyDB amb l'etiqueta "Correu" respectivament.

### Recuperació de dades
Estableix el camp de text "Oculta" amb el valor emmagatzemat en la BD TinyBD sota l'etiqueta de "Correu". Si no existeix el valor es mostrarà un text que diu: "Introdueix el correu"
