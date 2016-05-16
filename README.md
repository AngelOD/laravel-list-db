# laravel-list-db
Allows DB structure listing (with types)


## Installation

* Run Composer install

```
    composer require a2design/laravel-list-db
```

* Add service provider to your app config:

``` php
    'providers' => [
        ...
        A2Design\LaravelListDb\ListDbServiceProvider::class,
    ],
    ...
```


If you want to see table columns listing, use:

```
    php artisan table:columns tableName
```

And for models:

```
    php artidan model:columns modelName
```


## Formatting

- `%po` - Platform options
- `%nn` - Not Null
- `%dt` - Default Value
- `%ai` - Auto Increment
- `%c` - Column Name
- `%t` - Column Type
- `%u` - Unsigned
- `%l` - Column Length
- `%p` - Column Precision
- `%s` - Column Scale
- `%f` - Column is fixed