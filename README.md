# Introduction #

A learning exercise to build an OAuth client and server with visible HTTP calls
as opposed to using composer libaries to do all my dirty work :) I'll be following the
spec closely to ensure that it is inline with how OAuth 2.0 calls ought to be made.

## Installation ##

Clone the project to your workplace:

```
$ git clone https://github.com/martynbiz/oauth2-client-server
```

Run composer within each client and server directories:

```
$ cd client
$ composer install
$ cd ../server
$ composer install
```

Run server migrations to setup the DB:

```
./vendor/bin/phinx migrate
```

Run the following command to run both client and server locally:

```
$ php -S localhost:8080 -t client/public && php -S localhost:8081 -t server/public
```





TODO

build a client app, have it querying sso initially (/token, /authorize, etc)
