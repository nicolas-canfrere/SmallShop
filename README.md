# SmallShop

Domain Driven Design appliqué en exercice de recherche et de demo sur une base Symfony 4

## installation local

A la racine :

Pour lancer l'environnement de dev (Nginx/php7.2/Mysql)

nécessite Docker + docker-compose

```
$ docker-compose up
```

en locale, doit être ajoutée au fichier /etc/hosts (linux) la ligne :

```
127.0.0.1 smallshop.local
```

Ne pas oublier :

```
$ composer install
```
## Création du schema de base de données

se connecter au container smallshop_php

```
$ docker-compose exec smallshop_php /bin/bash
```

Dans le container

```
$ cd /SmallShop
$ php bin/console doctrine:schema:create
```

## Installation des fixtures

se connecter au container smallshop_php

```
$ docker-compose exec smallshop_php /bin/bash
```

Dans le container

```
$ cd /SmallShop
$ php bin/console doctrine:fixtures:load
```

## Accès à l'appli en local

front accessible par http://smallshop.local

et

admin accessible par http://smallshop.local/back-office

## TODOS

- decoupler le cryptage des mots de passe ( trop lié à Doctrine+Symfony Security)
- créer le compte utilisateur (login form, customer page, etc)
- continuer le stock (limite d'alerte - mettre à jour onSale, etc)
