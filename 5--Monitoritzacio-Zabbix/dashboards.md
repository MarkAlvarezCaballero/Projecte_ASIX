# Creacio de dashboards per centralitzar l'estat de les maquines

## Com crear un dashboard
Anem a `Monitoring -> Dashboard -> Create dashboard` amb les següents caracteristiques

- Propietari: <usuari\>
- Nom: Kubernetes cluster

![dashboard_create](../.Images/zabbix/dashboard_create.png)

Ens redirigira a la pagina d'edicio del dashboard, on podrem donar clic a qualsevol lloc dins de l'area negra per afegir un widget

![dashboard_widget](../.Images/zabbix/dashboard_widget.png)

Si donem clic s'ens obrira la finestra de configuracio del widget, on podem configurar diferents parametres, sobretot el tipus, ja que determinara com sera el widget. En aquest cas crearem un gràfic.

![dashboard_widget_config](../.Images/zabbix/dashboard_widget_config.png)

Els parametres més importants en un gràfic son `host pattern` i `item pattern` ja que determinaran el host i l'item del host del que s'agafaran les dades per mostrar-les. Seleccionarem com a host `node master` i com a item `carrega de la CPU (inactiva)`. Una vegada seleccionats, es mostrará un exemple de com es veuran les dades.

![dashboard_graph](../.Images/zabbix/dashboard_graph.png)

Al finalitzar la creació, es mostrara el grafic al dashboard.

![dashboard_graph_done](../.Images/zabbix/dashboard_graph_done.png)

## Caracteristiques dels widgets del dashboard principal

### Widget 1
- Tipus: Disponiblitat dels hosts
- Grup de hosts: `Kubernetes cluster`
- Tipus d'interficie: Agent Zabbix

### Widget 2
- Tipus: Text pla
- Items: `kubernetes master: Estat pods`

### Widget 3
- Tipus: Rellotge
- Tipus temps: Temps local

### Widget 4
- Tipus: Problemes
- Mostra: Problemes
- Grup de hosts: `Kubernetes cluster`

### Widget 5
- Tipus: Valor d'item
- Item: `kubernetes master: Pods en estat "Running"`

### Widget 6
- Tipus: Valor d'item
- Item: `kubernetes master: Estat API server`

### Widget 7
- Tipus: Gràfic
- Patró de host: `kubernetes master`
- Patro d'item: `Carrega CPU (inactiva)`

### Widget 8
- Tipus: Gràfic
- Patró de host: `kubernetes node1`
- Patro d'item: `Carrega CPU (inactiva)`
  
### Widget 9
- Tipus: Gràfic
- Patró de host: `kubernetes master`
- Patro d'item: `Disc disponible`

### Widget 10
- Tipus: Gràfic
- Patró de host: `kubernetes node1`
- Patro d'item: `Disc disponible`

### Widget 11
- Tipus: Gràfic
- Patró de host: `kubernetes master`
- Patro d'item: `Memoria disponible`

### Widget 12
- Tipus: Gràfic
- Patró de host: `kubernetes node1`
- Patro d'item: `Memoria disponible`
