
# Laravel Scheduling with Redis

## Before Installation

- Configure Database
- Configure Redis

## Installation

* Copy / rename env.example to env, don't forget to configure database and redis connection here
```bash
  cd /path-to-your-project
  composer install
  php artisan migrate
  php artisan serve
```
* Add cron entries to your server
```bash
  * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
⚡️ Enjoy...

## 🔗 Links
[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://arvyayren.my.id/)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/arvyayren/)