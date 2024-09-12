Sintaxi bàsica d'un fitxer.yaml

- **-name -->** Nom del playbook o nom de les tasques
- **hosts -->** Selecció dels grups sobre els que vols executar les tasques
- **remote_user -->** Per definir l'usuari remot
- **tasks -->** Definició de tasques
    - **-name:** Nom de la tasca 1 
    - Mòdul a utilitzar
        name: Nom del paquet
        state: Estat del paquet 

Per comprovar la sintaxis d'un fitxer YAML podem fer l'ús de la comanda seguent:

```bash
ansible-playbook -syntax-check ./playbook.yaml
```

Si volem executar un playbook executem la comanda seguent:

```bash
ansible-playbook nom_playbook.yaml
```

També el podem executar pas a pas:

```bash
ansible-playbook --step nom_playbook.yaml
```