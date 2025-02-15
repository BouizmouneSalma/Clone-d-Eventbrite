# Eventbrite Clone - Gestion d'Événements

## Description
Ce projet est un clone avancé d'Eventbrite permettant aux organisateurs de publier et gérer des événements, aux participants de réserver des billets en ligne, et aux administrateurs de superviser l'ensemble du système. Il suit une architecture PHP MVC et utilise PostgreSQL pour la gestion des données, avec AJAX pour des interactions dynamiques.

## Fonctionnalités Principales
### Utilisateurs
- Inscription et connexion sécurisée (bcrypt).
- Gestion des rôles : Organisateur, Participant, Admin.

### Événements
- Création, modification et validation des événements.
- Ajout d’images et gestion des catégories.

### Réservations
- Réservation et annulation de billets en ligne.
- Gestion des codes promo et réductions.

### Tableau de Bord & Back-office
- Statistiques en temps réel sur les ventes et réservations.
- Gestion des utilisateurs et modération des événements.

## Technologies Utilisées
- **Backend** : PHP 8.x, PostgreSQL, PDO (requêtes préparées).
- **Frontend** : HTML5, CSS3, JavaScript (ES6), Bootstrap 5 / TailwindCSS.
- **Interactions dynamiques** : AJAX.

## Installation
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/BouizmouneSalma/Clone-d-Eventbrite
   ```
2. Configurez la base de données PostgreSQL.
3. Installez les dépendances nécessaires.
4. Configurez les fichiers d’environnement (DB credentials).
5. Démarrez le serveur local :
   ```bash
   php -S localhost:8000
   ```

## Contributions
Les contributions sont les bienvenues ! Forkez le projet et proposez vos améliorations via des pull requests.

## Licence
Ce projet est sous licence MIT.

