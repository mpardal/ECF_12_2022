# Tests fonctionnels

## Premier test

Ce test est dans le fichier tests/Controller/FranchisePageTest.php

Le test effectué permet de vérifier qu'il n'y a pas la présence du bouton "Modifier" sur chaque franchise quand
l'utilisateur est identifié en tant que Franchise.

## Deuxième test

Ce test est dans le fichier tests/Controller/AdminPageTest.php

Le test effectué permet de vérifier qu'il y a bien la présence du bouton "Modifier" sur chaque franchise quand
l'utilisateur est identifié en tant qu'administrateur.

## Troisième test

Ce test est dans le fichier tests/Controller/AdminPageTest.php

Le test effectué permet de vérifier qu'un mail est bien envoyé au destinataire correspondant à l'adresse mail rempli
dans la base de données.

# Points de sécurité

J'ai utilisé comme point de sécurité, l'encodage des mots de passe, ainsi que la gestion des routes URL (access_control)