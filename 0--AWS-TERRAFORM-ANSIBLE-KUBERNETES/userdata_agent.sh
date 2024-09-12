#!/usr/bin/env bash
# set -x: Habilita el mode de depuració, fent que cada comanda executada es mostri a la sortida.
set -x

# exec > >(tee /var/log/user-data.log|logger -t user-data -s 2>/dev/console) 2>&1: Redirigeix tota la sortida estàndard i d'error a un fitxer de registre (/var/log/user-data.log), al logger del sistema (logger -t user-data -s 2>/dev/console).
exec > >(tee /var/log/user-data.log|logger -t user-data -s 2>/dev/console) 2>&1

# export PATH="$PATH:/usr/bin": Afegeix /usr/bin al PATH de l'intèrpret de comandes, assegurant-se que les utilitats necessàries estan disponibles.
export PATH="$PATH:/usr/bin"

# Espera durant 10 segons per assegurar-se que els serveis necessaris estan completament iniciats abans de continuar.
sleep 10

# Actualitzem els paquets i instal·larem git, python3-pip i ansible.
sudo apt update
sudo apt install -y git python3-pip ansible
pip3 install ansible

# Clonem el repositori de GitHub que es del noi del que hem fet servir el tutorial.
git clone https://github.com/pepesan/ejemplos-ansible.git

# Canvia al directori 27_rke dins del repositori clonat.
cd ejemplos-ansible/27_rke

# Executa el playbook rke_node_agent_install.yaml.
ansible-playbook rke_node_agent_install.yaml









