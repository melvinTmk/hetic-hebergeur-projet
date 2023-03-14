# Symfony x Docker
#### Avec MariaDB, PhpMyAdmin & MailDev

Pour lancer le projet :
```shell
docker-compose up -d
```

Pensez ensuite à aller exécuter toutes vos commandes depuis l'intérieur
du container.

Par exemple :
```shell
cd symfony_project
composer install
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load
```

Enfin, modifiez la config DB dans le fichier .env de Symfony :
```dotenv
DATABASE_URL=mysql://root:ChangeMeLater@db:3306/symfony_db?serverVersion=mariadb-10.7.1
```