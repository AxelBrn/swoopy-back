# Swoopy API
[![Build Status](https://travis-ci.com/AxelBrn/swoopy-back.svg?branch=develop)](https://travis-ci.com/AxelBrn/swoopy-back)

## Pre-requirement 
- PHP 7.4 >=
- Composer 2
- Symfony CLI
- OpenSSL
- PostgreSQL 13

## Project setup
```bash
# Install dependencies of this project
composer install
```

- Copy content of .env file and paste in new .env.local file. After put your local environnment infos in .env.local.

```bash
# This command create a RSA key pair for create JWT
php bin/generate
# If you use bash run :
php bin/generate -b
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
