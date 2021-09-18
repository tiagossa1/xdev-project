# xDev Project

xDev is a community website created for both old and new students in ATEC to interact with each other.

## Installation

## Web API
```bash
cp .env.example .env
composer install
```

Get a MySQL service and create a database called "laravel". You may call it something else, just remember to change DB_DATABASE on .env file that you copied earlier. Also, check DB_USERNAME and DB_PASSWORD and see if it matches with yours.

```bash
php artisan migrate:fresh --seed
php artisan serve
```

## Web Site

```bash
cp .env.example .env
composer install
npm install
npm run dev
```

Copy the API URL and change API_URL on .env file.

```bash
php artisan serve
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
