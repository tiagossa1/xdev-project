# xDev Project

xDev is a community website created for both old and new students in ATEC to interact with each other.

## Tecnologies

![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

## Installation

To run this project, you will need to create an account on Mailtrap and Pusher. You also will need to change the following environment variables to your .env file:

To get Pusher keys, go to your pusher app > App Keys.

- Web API env:
- `MAIL_HOST`: smtp.mailtrap.io (check Mailtrap)
- `MAIL_PORT`: 2525 (check Mailtrap)
- `MAIL_USERNAME`: Check Mailtrap inbox settings.
- `MAIL_PASSWORD:` Check Mailtrap inbox settings.
- `MAIL_ENCRYPTION`: Check Mailtrap inbox settings.
- `MAIL_FROM_ADDRESS`: verify@xdev.pt (it can be any fake email address, but we use this).
- `PUSHER_APP_ID`: Check Pusher.
- `PUSHER_APP_KEY`: Check Pusher.
- `PUSHER_APP_SECRET`: Check Pusher.
- `PUSHER_APP_CLUSTER`: Check Pusher.
- `PUSHER_APP_NAME`: Check Pusher.
- `DB_USERNAME`: MySQL username. If you're using Xampp, it should be "root".
- `DB_PASSWORD` MySQL password. If you're using Xampp and you did NOT change it, leave it blank.

Website env:
- `VUE_APP_API_URL`: Once the web API is running, put the URL here. e.g. http://127.0.0.1:8000
- `VUE_APP_PUSHER_APP_KEY`: Check Pusher.
- `VUE_APP_PUSHER_CHANNEL_NAME`: This is the channel (app) name from Pusher that you created previously.

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
