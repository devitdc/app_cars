[![Release version](https://img.shields.io/badge/release-v1.0.0-blue)]()
[![Symfony version](https://img.shields.io/badge/symfony-4.4.49-blue)]()
[![PHP version](https://img.shields.io/badge/php->=7.1.3-blue)]()
# Titus

Application de gestion de véhicules avec Symfony 4.4 permettant :
* une gestion des marques, modèles et voitures (*ajout, modification, suppression*),
* gestion des utilisateurs (*ajout, modification, suppression*).

## Environnement de développement

### Pré-requis

* Symfony 4.4.49
* PHP >= 7.1.3
* MariaDB 10.10.2
* BootStrap 5.2 
* FontAwesome 6.2

Pour vérifier que les pré-requis sont respectés :
```bash
symfony check:requirements
```

Pour vérifier qu'aucun packages ne présentent des vulnérabilités :
```bash
symfony security:check
```

Créer le fichier **.env** en s'appuyant du fichier **.env-template** avant d'exécuter les commandes suivantes.

### Pour démarrer l'environnement de développement

Un exemple de données est disponible dans des fixtures :
* UserFixtures : pour la création de 2 comptes utilisateurs, un admin et un utilisateur.
* VehicleFixtures : pour la création de données d'exemples avec des véhicules.

Pour charger les fixtures, il suffit d'exécuter le **makefile** avec la commande :
```bash
make start
```

Voici la liste des comptes disponibles :
* admin@demo.local : admin123
* user@demo.local : user1234

```bash
composer install
chmod +x bin/*
bin/console doctrine:database:create
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
symfony server:start
```

### Pour démarrer l'environnement de production

```bash
composer install --no-dev --optimize-autloader
chmod +x bin/*
bin/console doctrine:database:create
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```
