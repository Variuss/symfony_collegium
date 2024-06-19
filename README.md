# symfony_collegium

Symfony app is in skeleton directory, angular app is in angular-crud directory.

## Installation

UPDATE DEPENDENCIES:

For symfony:
$> composer install

For angular:
$> npm install

CONFIGURE lexik_jwt_authentication:

Generate new key pair:

$> php bin/console lexik:jwt:generate-keypair

or make it manually for example:
$> mkdir config/jwt
$> openssl genrsa -out config/jwt/private.pem -aes256 4096
$> openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

Keys must be in config/jwt directory and match the paraphrase from env file.

## Api
Login:
POST /api/login_check

BODY
{
    "username":<username_here>,
    "password":<password_here>
}

Register:
POST /api/register

BODY
{
    "email":<email_here>,
    "password":<password_here>
}

Get lessons:
GET /api/lessons

Get lesson:
GET /api/lessons/{id}

Create lesson:
POST /api/lessons

BODY
{
    "topic":<topic_here>,
    "content":<content_here>
}

Edit lesson:
PUT /api/lessons

Create lesson:
POST /api/lessons

BODY
{
    "topic":<topic_here>,
    "content":<content_here>
}

Delete lesson:
DELETE /api/lessons/{id}

## Explanations

Addresses used locally to successfully run project:

Symfony API
http://localhost:80/symfony_collegium/skeleton/public/api/
Angular APP
http://localhost:4200/

All users created already in database has the same password "test123".