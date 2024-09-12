#!/bin/bash

# Comprovem l'estat del servei, per veure si sha fet correctament i està actiu.
ansible webservers-nginx -m shell -a "systemctl status nginx" -b

