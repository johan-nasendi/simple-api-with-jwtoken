<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Cara PULL #
```
git pull
cp .env.example .env
copy paste isi .env  | env-ser
php artisan key:generate
```

## DOCS API

Endpoint | Description
------|------------
Login or Generate token | `/api/v1/web/auth/login` 
Register with token | `/api/v1/web/auth/register` 
Logout | `/api/v1/web/auth/logout` 

Show All Users | `/api/v1/web/all/users` 


## NOTES
- [x] Logout harus wajib mengdeskirpsikan token pada body json jika mengunakan postman
- [x] All users harus wajib mengdeskirpsikan token pada authorization -> select Bearer Token dan masukan token yang digenerate dari hasil login



### Install Composer
Gunakan perintah ini untuk membuat file composer.lock pada folder project laravel.
```
composer install

```
### Update Composer
Gunakan perintah ini untuk membuat file composer.lock pada folder project laravel.
```
composer update
```

### Running Server
Gunakan perintah ini untuk menjalankan server laravel.
```
php artisan serve
```

### Generate Key
Gunakan perintah ini untuk mengatur isi dari APP_KEY pada file .env
```
php artisan key:generate
```




