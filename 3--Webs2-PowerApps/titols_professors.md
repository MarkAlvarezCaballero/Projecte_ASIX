# Pantalla per Visualitzar els Títols d'el Professor seleccionat

![Títols d'el Professor seleccionat](../.Images/powerapps/titols_professor_seleccionat.png)

## Qué fa aquesta pantalla?

<p>Aquesta pantalla mostra en format de galeria tots els títols acadèmics que posseeix un professor determinat. Com a totes les altres pàgines de l'aplicació, inclou un botó per retornar a la pantalla anterior, facilitant la navegació dins de l'aplicació. A més, disposa d'un botó específic per eliminar qualsevol títol acadèmic del professor, proporcionant una gestió eficient i directa de les seves qualificacions.</p>

## Com obté els títols?

<p>Per obtenir els títols a mostrar, el sistema realitza una cerca a la llista ‘Titols Professors’. Filtra tots els registres on la identificació (ID) del professor coincideixi amb la ID del professor que s'ha proporcionat des de la pantalla ‘LlistaProfessors’.</p>

![Obtenir títols](../.Images/powerapps/com_obte_els_titols.png)

## Com mostra els títols?

<p>Els títols a la galeria són mostrats concatenant el seu tipus i el seu nom. Aquesta informació s'obté buscant a la base de dades utilitzant la identificació (ID) del títol acadèmic específic.</p>

![Mostrar títols](../.Images/powerapps/mostrar_titols.png)

## Botons

### Botó per anar cap enrere

<p>La funció d'aquest botó és retornar a la pantalla 'LlistaProfessors'. El botó es mostra en forma de creu.</p>

![Botó per anar cap enrere](../.Images/powerapps/boto_tornar_enrere.png)

### Botó per eliminar professor

<p>Elimina de la llista ‘Titols Professors’ el primer registre trobat on la identificació (ID) del títol coincideixi amb la ID del títol que es desitja eliminar, i on la ID del professor correspongui amb la del professor proporcionat des de la pantalla anterior.</p>

![Botó per eliminar professor](../.Images/powerapps/boto_eliminar_titol_profe.png)