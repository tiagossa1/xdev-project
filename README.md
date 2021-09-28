# xDev Project

xDev is a community website created for both old and new students in ATEC to interact with each other.

## Tecnologies

![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

## Installation

To run this project, you will need to change the following environment variables to your .env file:

- `VUE_APP_API_URL` (on web site; once you run the Web API, change it here)
- `DB_USERNAME` (on web API)
- `DB_PASSWORD` (on web API)

## Web API
```bash
cp .env.example .env
composer install
php artisan migrate:fresh --seed
php artisan key:generate
php artisan serve
```

## Web Site
```bash
cp .env.example .env
npm install
npm run serve
```

## Authors

- [@tiagossa1](https://github.com/tiagossa1)
- [@pintarolas](https://github.com/pintarolas)
- [@Scantraxzu](https://github.com/Scantraxzu)
- [@peixecozid0](https://github.com/peixecozid0)

## License
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)
