# laravel-list-db
Allows DB structure listing for Laravel's Eloquent models.

## Installation

* Run Composer install

```
    composer require angelod/laravel-list-db
```


If you want to see table columns listing, use:

```
    php artisan dbshow:table tableName
```

And for models:

```
    php artisan dbshow:model modelName
```

There are also versions that works on all the tables or models:

```
    php artisan dbshow:tables
    
    php artisan dbshow:models
```

In addition there are a few options deciding how much should be displayed in the listings.
These can be seen by using the ```--help``` option with a given command.
