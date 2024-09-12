# Aquí va la clau SSH pública
# La ruta a la clau pública SSH que es farà servir per crear el parell de claus a AWS.
# No sabem per quin motiu necesitem crear les claus a les instancies de AWS, es una pregunta que tenim.
ssh_key_path="id_rsa.pub"

# La ruta a la clau privada SSH que es farà servir per connectar-se a les instàncies.
# Aquest valor es fa servir en les connexions SSH definides als recursos aws_instance per accedir a les instàncies de servidor i d'agent.
ssh_key_private_path="id_rsa"

# L'identificador de la VPC on es crearan els recursos.
# Una VPC (Virtual Private Cloud) és un entorn de xarxa virtual a Amazon Web Services (AWS)
vpc_id="vpc-011d784fe9ecfb912"
