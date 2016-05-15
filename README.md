# laravel-list-db
Allows DB structure listing (with types)


## Installation

```
    composer require a2design/laravel-list-db
```

## Usage

Add service provider to your app config:

```
    ...
        A2Design\LaravelListDb\ListDbServiceProvider::class,
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