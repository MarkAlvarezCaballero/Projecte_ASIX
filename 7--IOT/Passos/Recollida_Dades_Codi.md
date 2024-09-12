## Recollida_Dades

### Inicialització
Inicialitzem una variable global anomenada "temperatura" amb valor 0.

Inicialitzem una variable global anomenada "humitat" amb valor 0.

Inicialitzem una variable global anomenada "hora" amb valor 0.

Inicialitzem una variable global anomenada "minuto" amb valor 0.

Inicialitzem una variable global anomenada "segundo" amb valor 0.

Inicialitzem una variable global anomenada "milisegundo" amb valor 0.

<img src="../../.Images/IOT/variables.PNG" alt="Variables" style="width: 300px;"> <br><br>

### Inicialitzador "Reloj1"

Incrementa mil·lisegons, quan passa de 100 sumarà 1 als segons.

Incrementa els segons, quan passa de 60 sumarà 1 als minuts.

Incrementa els minuts, quan passa de 60 sumarà 1 a les hores.

<img src="../../.Images/IOT/reloj1.PNG" alt="Reloj1" style="width: 500px;"> <br><br>

#### Mostrar temps:

Actualitza els camps de les variables: global hora, global minuto, global segundo i global milisegundo.

<img src="../../.Images/IOT/mostrar_tiempo.PNG" alt="MostrarTiempo" style="width: 500px;"> <br><br>

### Inicialitzador Recollida_Dades

A l'inicialitzar, es configuren els botons de la interfície: Començar (visible), Parar (invisible), Reiniciar (invisible), Continuar (invisible), Guardar (invisible).

<img src="../../.Images/IOT/recollida_dades.PNG" alt="Recollida Dades" style="width: 500px;"> <br><br>

### Botons:
#### Començar:
S'amaga el botó de "Començar".

Es mostra el botó "Parar".

Es mostra el botó "Reiniciar".

Es configura l'URL per obtenir dades del clima, agafant la latitud i altitud del sensor d'ubicació (SensorDeUbicación1), tot junt amb la clau API emmagatzemada en la variable global Key.

Es crida a la funció Web2. Obtener per obtenir les dades de l'URL configurada. Es crida a la funció Podómetro1. Iniciar per començar el podòmetre

<img src="../../.Images/IOT/començar.PNG" alt="Començar" style="width: 500px;"> <br><br>

#### Continuar:
S'amaga el botó de "Guardar".

S'amaga el botó de "Continuar".

Es mostra el botó "Parar".

Es mostra el botó "Reiniciar".

<img src="../../.Images/IOT/continuar.PNG" alt="Continuar" style="width: 500px;"> <br><br>

#### Parar:

S'amaga el botó de "Parar".

Es mostra el botó "Reiniciar".

Es mostra el botó "Continuar".

Es mostra el botó "Guardar".

<img src="../../.Images/IOT/parar.PNG" alt="Parar" style="width: 500px;"> <br><br>

#### Reiniciar:

En fer clic es reinicien les variables globals: global hora, global minuto, global segundo i global milisegundo a 0.

<img src="../../.Images/IOT/reiniciar.PNG" alt="Reiniciar" style="width: 500px;"> <br><br>

#### Guardar
En prémer guardar, agafa les variables: milisegundos, segundos, minutos, horas, pes, altura, correu, pasos, temperatura, humitat i construeix l'URL per enviar al .PHP guardat en la variable "orden" i crida a Web1 i ho envia.

<img src="../../.Images/IOT/guardar.PNG" alt="Guardar" style="width: 500px;"> <br><br>

<img src="../../.Images/IOT/web2.PNG" alt="Web2" style="width: 500px;"> <br><br>
