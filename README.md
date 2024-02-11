# Swoopy API

## Pre-requirement 
- PHP 8.2 >=
- Composer 2
- Symfony CLI
- OpenSSL
- MariaDB 10.11.X

## Project setup
```bash
# Install dependencies of this project
composer install
```

- Copy content of .env file and paste in new .env.local file. After put your local environnment infos in .env.local.

```bash
# This command create a RSA key pair for create JWT
php bin/console lexik:jwt:generate-keypair
```

### Database Setup
```bash
# Create the Database
symfony console doctrine:database:create
```
```bash
# Migrate the database
symfony console doctrine:migrations:migrate
```

## Run the project
```
symfony server:start
```

## Stop the project
```
symfony server:stop
```

## Run the Unit Tests
```bash
composer unit:test
```