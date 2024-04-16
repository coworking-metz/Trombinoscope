# Trombinoscope

## Description
Cette application web affiche un trombinoscope dynamique qui permet de visualiser les membres présents. Elle offre des fonctionnalités telles que la gestion des photos anonymes, la mise en cache ou non des ressources et l'affichage d'informations dynamiques sur l'état de l'adhésion et du solde des utilisateurs.

## Fonctionnalités
- **Affichage conditionnel** : L'application peut fonctionner en mode test pour simuler de grands volumes d'utilisateurs. AJouter un paramètres `test`dans l'url avec comme valeur le nombre de photos à afficher
- **Personnalisation avancée** : Personnalisation de l'affichage en fonction du nombre d'utilisateurs, avec des dimensions de grille ajustables.
- **Liens vers des actions d'administration** : Accès rapide à la gestion des utilisateurs via des icônes pour la modification, la gestion et l'exportation de données utilisateur.

## Utilisation
- Lancer `docker-compose up --build` pour lancer l'environnemen docker
- Lancez l'application via votre navigateur en accédant à l'adresse du serveur http://localhost:7981 où le code a été déployé.
- Utilisez les paramètres `admin`, `anonyme`, et `test` dans l'URL pour tester différentes configurations et fonctionnalités.


## Licence
Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, le modifier et le distribuer selon les termes de la licence.
