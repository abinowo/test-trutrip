# Test Trutrip

The Test Trutrip [Documentation](https://documenter.getpostman.com/view/1331161/2sA3s7jUQ3)

## How to install

```
1. Clone this repo
2. cp .env.example .env
3. php artisan key:generate
3. change mysql configuration
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=trutrip
    DB_USERNAME=root
    DB_PASSWORD=
4. php artisan migrate:refresh --seed
```

## How to test

`php artisan test`
