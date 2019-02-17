# SmallShop

Domain Driven Design appliqué en exercice de recherche et de demo sur une base Symfony 4

## installation locale

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


front accessible par http://smallshop.local
et
admin accessible par http://smallshop.local/back-office
