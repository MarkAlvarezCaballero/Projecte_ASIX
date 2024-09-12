## Instal·lació de Linux Containers

Fem la instal·lació del demon de lxc.
L'iniciem i ho deixem tot per defecte excepte la capacitat, que posarem 30GiB.

```bash
sudo apt install lxd
sudo init lxd
```
Una vegada tenim iniciat lxd, creem un contenidor amb una de les imatges que porta predefinida lxc. Creem Ubuntu2204.

```bash
lxc launch ubuntu:22.04 Ubuntu2204
```




