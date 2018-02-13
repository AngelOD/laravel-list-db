# laravel-list-db
Allows DB structure listing (with types)

[![Code Climate](https://codeclimate.com/github/AngelOD/laravel-list-db/badges/gpa.svg)](https://codeclimate.com/github/AngelOD/laravel-list-db)

## Installation

* Run Composer install

```
    composer require angelod/laravel-list-db
```


If you want to see table columns listing, use:

```
    php artisan table:columns tableName
```

And for models:

```
    php artisan model:columns modelName
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
