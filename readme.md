[![Release version](https://img.shields.io/badge/release-v1.0.1-blue)]()
[![Symfony version](https://img.shields.io/badge/symfony-4.4.49-blue)]()
[![PHP version](https://img.shields.io/badge/php->=7.1.3-blue)]()
# Titus

Application de gestion de véhicules avec Symfony 4.4 permettant :
* une gestion des marques, modèles et voitures (*ajout, modification, suppression*),
* gestion des utilisateurs (*ajout, modification, suppression*).

Il s'agit d'une application de démo, accessible depuis [https://platformdev.fr/app_cars](https://platformdev.fr/app_cars) développé par Vincent VELOSO Développeur Backend ([https://it-dc.fr](https://it-dc.fr)).
**Les données sont réinitialisées tous les jours.**

## Pré-requis

* Symfony 4.4.49
* PHP >= 7.1.3
* MariaDB 10.10.2
* BootStrap 5.2.3 
* FontAwesome 6.2.0

Pour vérifier que les pré-requis sont respectés :
```bash
symfony check:requirements
```

Pour vérifier qu'aucun packages ne présentent des vulnérabilités :
```bash
symfony security:check
```

## Pour démarrer l'environnement de développement

Un exemple de données est disponible dans des fixtures :
* **UserFixtures** : pour la création de 2 comptes utilisateurs, un admin et un utilisateur.
* **VehicleFixtures** : pour la création de données d'exemples avec des véhicules.

Voici la liste des comptes disponibles :
* admin@demo.local : admin123
* user@demo.local : user1234

#### Pensez à créer le fichier **.env** avant d'exécuter les commandes suivantes. Vous pouvez utiliser le fichier .env-template comme modèle.
```bash
composer install
chmod +x bin/*
make start-dev # Pour charger les fixtures
symfony server:start
```

## Pour démarrer l'environnement de production

#### Pensez à créer le fichier **.env** avant d'exécuter les commandes suivantes. Vous pouvez utiliser le fichier .env-template comme modèle.

```bash
composer install --no-dev --optimize-autloader
chmod +x bin/*
make start-prod
```
