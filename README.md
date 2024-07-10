<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About DIMS

DIMS (Designed Integrated Management System) software solution is a small South African based company that takes pride in understanding your business and providing digital solutions to your problems. Even those that you never knew you had.

From point of sale to delivery, our system integrates with your existing ERP system (such as Sage Pastel Partner, Sage Pastel Evolution, Sage 300, Palladium Accounting, IQ, Xero and Syspro) and streamlines your entire business process. Our offerings include:-

- Maximizing the time spent with your client at the "coal face" using powerful reporting and offsite ordering ability
- Providing data analysis for the sales team, both internally and externally
- Optimizing business operations with regards to the warehouse management, picking, loading and delivering and stocktaking
    - ISellIt
    - IPickIt
    - ILoadIt
    - IMoveIt
    - ICountIt
- Increases business revenue, by saving time and working efficiently
- Increases the accuracy of deliveries and consequently client satisfaction
- Improves your customer service levels, repeat business and retention

Our integrated webstore entices your customers with the convenience of ordering online, anywhere, anytime.

## Installation

Clone the repository

    git clone git@github.com:Raesetja-reffs/myshop2024.git

Switch to the repo folder

    cd myshop2024

Install all the dependencies using composer

    composer install

If you need to setup the Database Based Dims then please follow below steps

- Copy the example env file and make the required configuration changes in the .env file

        cp .env.example .env

- Migrate the company roles and company permission in local database
    
        php artisan migrate

- Migrate the company roles and company permission in universal database (optional step)
    
        php artisan migrate --database=your_database_connection

- Run the seeder for add Linx System Company

        php artisan db:seed LinxCompanySeeder

If you need to setup the API Based Dims then please follow below steps

- Copy the example env file and make the required configuration changes in the .env file

        cp .env.api .env

- Run the API Central Database tables

        php artisan migrate --path=database/migrations/api_based_migrations

- Run the seeder for seed the default admin user

        php artisan db:seed --class=CentralUserSeeder

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
