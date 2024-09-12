### Laboratori Amazon EC2

1. Seleccionarem el servei de EC2 i li posarem primer de tot un nom. <br><br>
  ![ec2.1](../../.Images/Cloud/ec2.1.PNG)

2. Seleccionarem la ISO d'amazon Linux → Amazon Linux 2023 AMI x86_64 (HVM). <br><br>
  ![ec2.2](../../.Images/Cloud/ec2.2.PNG)

3. Escollim el tipus d'instància, utilitzarem la més petita i amb menys costos. <br><br>
  ![ec2.3](../../.Images/Cloud/ec2.3.PNG)

4. Hem de posar la clau, en aquest cas i amb la nostra llicència només podem utilitzar la predefinida. <br><br>
  ![ec2.4](../../.Images/Cloud/ec2.4.PNG)

5. Configuració de xarxa <br><br>
  ![ec2.5](../../.Images/Cloud/ec2.5.PNG)

6. Configuració d'emmagatzematge <br><br>
  ![ec2.6](../../.Images/Cloud/ec2.6.PNG)

7. A l'apartat de detalls avançats es pot posar un script, posarem el següent per poder executar una instància on hi estarà un html.

Aquest script fa el següent:
- Actualitza el servidor.
- Instal·la un servidor web Apache. (HTTPS)
- Configura el servidor web perquè comenci automàticament durant l'arrencada.
- Activa el servidor web.
- Crea una pàgina web senzilla. <br><br>
  ![ec2.7](../../.Images/Cloud/ec2.7.PNG)

8. Finalment, podrem donar a llançar instància i esperem el missatge de "tot correcte" i anem a veure totes les nostres instàncies. <br><br>
  ![ec2.8](../../.Images/Cloud/ec2.8.PNG)

9. Ara tindrem la nostra instància en execució, la seleccionarem i anirem a detalls (Important agafar la IP Pública!!) <br><br>
  ![ec2.9](../../.Images/Cloud/ec2.9.PNG)

10. Encara no podrem entrar al .html perquè per seguretat no podem, així que haurem d'anar a "Grups de seguretat." <br><br>
  ![ec2.10](../../.Images/Cloud/ec2.10.PNG)

11. Dins la pràctica ens fa crear una regla de seguretat d'entrada perquè ho accepti tot per HTTP. <br><br>
  ![ec2.11](../../.Images/Cloud/ec2.11.PNG)

12. Finalment, amb la regla de seguretat configurada podrem entrar dins de la pàgina amb la nostra instància EC2 creada. <br><br>
  ![ec2.12](../../.Images/Cloud/ec2.12.PNG)
