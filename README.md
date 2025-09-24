# Invoices

Ini adalah website untuk membuat invoices.

## Pre-requirement

1. Aplikasi Web Server (contohnya: Laragon/Laravel Herd) atau web server lainnya.
2. Composer untuk package manager PHP.
3. NodeJS dengan NPM untuk package manager JS.
4. PHP versi min. 8.3.
5. RDBMS atau SQlite.

## Installation

1. Install dependensi

    ```sh
    composer install
    npm install && npm run dev
    ```

2. Jalankan migrasi database dan database seeder untuk mengisi tabel customer dengan data dummy.

    ```sh
    php artisan migrate --seed
    ```

4. Akses di localhost.

## Framework dan Library

> Framework: Laravel 12

Library PHP:
+ `simplesoftwareio/simple-qrcode` > QR Code Generator
+ `yajra/laravel-oci8` > Laravel Oracle database driver

Library JS:
+ `alpinejs` > library interaktivitas secara deklaratif dan interaktif.
+ `paper-css` > library untuk template invoice
+ `toastify-js` > library untuk notifikasi toast
