Zetia Agency - Projet de Site Freelance

Présentation du Projet

Zetia Agency est une plateforme web développée en Symfony permettant à un freelance de présenter ses services en graphisme, web design, community management et intégration WordPress/PrestaShop. Le site comprend également une boutique en ligne où des illustrations numériques sont mises en vente. Ce projet combine une interface utilisateur fluide et un système de gestion sécurisé pour optimiser l'expérience des visiteurs et des administrateurs.

Technologies Utilisées

Backend : Symfony (PHP, Doctrine ORM, MySQL)

Frontend : HTML, SCSS, JavaScript

Base de données : MySQL

Gestion des assets : Webpack

Authentification & Sécurité : Symfony Security, bcrypt pour le hashage des mots de passe

Paiement en ligne : Intégration Stripe

Gestion des images : EasyAdmin pour les uploads d'illustrations

Installation et Configuration

1. Cloner le projet

git clone https://github.com/ton-profil/zetia-agency.git

2. Installation des dépendances

composer install
yarn install && yarn encore dev

3. Configuration des variables d'environnement

Créer un fichier .env.local et y ajouter :

APP_ENV=dev
DATABASE_URL="mysql://root:root@127.0.0.1:3306/zetia"
STRIPE_SECRET_KEY="sk_test_xxxx"
STRIPE_PUBLIC_KEY="pk_test_xxxx"
DOMAIN="http://localhost:8000"

4. Création de la base de données et migration

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

5. Lancer le serveur Symfony

symfony serve

Le site est accessible via http://localhost:8000.

Rôles et Scénarios d’Utilisation

Utilisateur non-administrateur

L’utilisateur peut naviguer sur le site pour consulter les services proposés sur la page d’accueil, découvrir les réalisations dans la section portfolio et visiter la boutique en ligne. Pour effectuer un achat, il doit s’inscrire ou se connecter à son compte. Une fois authentifié, il peut ajouter des illustrations à son panier et procéder au paiement via Stripe. Après validation de la commande, il reçoit un e-mail de confirmation et peut suivre ses achats depuis son espace personnel.

Administrateur

L’administrateur a accès à un tableau de bord via EasyAdmin lui permettant de gérer les produits de la boutique. Il peut ajouter, modifier ou supprimer des illustrations en toute autonomie. Il peut également gérer les utilisateurs inscrits et surveiller l’activité sur le site.

Problèmes Courants et Solutions

Erreur de connexion Stripe : Vérifier que les clés API Stripe sont bien renseignées dans le fichier .env.local.

Problème de cache Symfony : Si des changements ne sont pas pris en compte, vider le cache avec php bin/console cache:clear.

Fonctionnalités Futures

Mise en place d’un programme de fidélité

Intégration d’un mode multi-langue

Amélioration du référencement SEO

Remerciements

Merci à tous ceux qui ont contribué à ce projet, en particulier mon mentor et mes collègues développeurs. Ce projet représente une avancée significative dans mon parcours professionnel et une application concrète de mes compétences en développement web.

Contact : Pour toute question ou suggestion, n'hésitez pas à me contacter à maylis.pala.pro@gmail.com