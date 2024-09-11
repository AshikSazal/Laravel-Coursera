@REM m means migration and f means factory
php artisan make:model Job -mf
php artisan make:controller JobController --resource
php artisan migrate:refresh --seed

@REM It will show the debug report below of the browser
@REM This could expose the data that's why I am using this in development dependency of composer github.com/barryvdh/laravel-debugbar
composer require barryvdh/laravel-debugbar --dev

npm install -D tailwindcss postcss autoprefixer
npx tailwind init -p
php artisan make:component Layout --view
php artisan make:component Card --view
php artisan make:component Tag --view
php artisan make:component LinkButton --view
php artisan make:component JobCard --view
php artisan make:component Breadcrumbs
npm install -D @tailwindcss/forms
php artisan make:component RadioGroup

@REM php run in cmd
php -a
@REM var_dump(array_combine(array_map('ucfirst',['true','false']),['true','false']))

php artisan make:component MainButton --view
npm install alpinejs