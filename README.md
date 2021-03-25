# p6_snowtricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0c5ad7dd97c94bf08800164dc71a82b1)](https://app.codacy.com/gh/Loly-webdev/p6_snowtricks?utm_source=github.com&utm_medium=referral&utm_content=Loly-webdev/p6_snowtricks&utm_campaign=Badge_Grade_Settings)

Jimmy Sweat is an ambitious entrepreneur passionate about snowboarding. Its objective is the creation of a collaborative
site to make this sport known to the general public and help in the learning of tricks.
## Requirements

1. Have php 7.4 or higher
2. Download and install the project's front-end dependencies with [Npm](https://www.npmjs.com/get-npm)
   and [Yarn](https://yarnpkg.com/) :

## Installation

1. Clone and download the repository GitHub :
```shell
    git clone https://github.com/Loly-webdev/p6_snowtricks.git
```
2. Download and install the back-end dependencies of the project with [Composer](https://getcomposer.org/download/) :
```shell
    composer install
```
3. Configure your environment variables such as connection to the database, your SMTP server, email address in the
   file `.env`.

4. Create the database if it does not already exist, type the command below :
```
    php bin/console doctrine:database:create
```
5. Create the different tables in the database by applying migrations :
```
    php bin/console doctrine:migrations:migrate
```
6. Install fixtures to have data :
```
    php bin/console doctrine:fixtures:load
```
7. Starting the Symfony server :
```shell
    symfony server:start
```
