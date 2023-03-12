# P6 Openclassrooms - Snowtricks - Erwan Carlini

<!-- [![SymfonyInsight](https://insight.symfony.com/projects/3e4940fc-7979-4f2e-a18e-20c1e0ffdf34/big.svg)](https://insight.symfony.com/projects/3e4940fc-7979-4f2e-a18e-20c1e0ffdf34) -->
---------------

## Starting project


### Requirements

- PHP : 8.1.0
- MySQL 8.0.30
- Composer
- Symfony 6.2

### Packages Installation

First, clone project and place the project in a new folder, then install all composer packages with command line : ``composer install``.  
You can use ``composer update`` to update the libraries used in the project.

### Import database

First, you will need to create your database Snowtricks and change the value of DATABASE_URL in the file .env to match with your database parameters.  
To get all necessaries datas, you can use two differents ways.  
* Solution 1 : in your PhpMyAdmin, import snowtrick-db.sql in your new database folder from root directory.  
* Solution 2 :  
 `* Run ``symfony console doctrine:database:create`` in command to create your database  
 `* Run ``symfony console doctrine:database:migrate`` in command to create your tables in your DB from the entities files  
  `* Run ``php bin/console doctrine:fixtures:load`` to get the basic datas of this project  

### Mailer configuration settings  

Then, we need to configure the .env file to start the project correctly and use the sending mail features.     
You will have to change the value of MAILER_DSN in the .env file to match with your mailer parameters.  

### Admin features

If you want to get all access in the project, you can give yourselves the admin role by adding the value "ROLE_ADMIN" in the JSON, in the 'user' table column 'roles' on your account row.  

## Libraries use list

* Symfony  
* Doctrine  
* Twig  
