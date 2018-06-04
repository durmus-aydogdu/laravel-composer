# Composer Commands Via Artisan

All you need to run composer commands via artisan


## Installation

    composer require durmus-aydogdu/laravel-composer

If you are using Laravel 5.5+, there is no need to manually register the service provider.
However, if you are using an earlier version of Laravel, register the `ComposerCommandServiceProvider` in your app configuration file:

    'providers' => [
        // Other service providers...
    
        DurmusAydogdu\LaravelComposer\ComposerCommandServiceProvider::class,
    ],
   
   
# Available Commands
             
- php artisan composer:clear-cache - Delete all content from Composer's cache directories
- php artisan composer:dump-autoload - Regenerate framework autoload files
- php artisan composer:install - Resolve the dependencies and install them
- php artisan composer:remove - Remove exist package from the composer.json file
- php artisan composer:require - Add new package to the composer.json file
- php artisan composer:run - Run composer command with params
- php artisan composer:update - Get the latest versions of the dependencies and update packages
    
              
# Usage

- composer clear-cache
        
        php artisan composer:clear-cache
        
- composer dump-autload -o

        php artisan composer:dump-autoload --param="-o" 

- composer install

        php artisan composer:install
    
- composer remove durmus-aydogdu/laravel-resource  

        php artisan composer:remove --package=durmus-aydogdu/laravel-resource
        
- composer require durmus-aydogdu/laravel-resource

        php artisan composer:require --package=durmus-aydogdu/laravel-resource
       
- composer update

        php artisan composer:update

- composer update durmus-aydogdu/laravel-resource

        php artisan composer:update --package=durmus-aydogdu/laravel-resource       

### You can run all commands with  `php artisan composer:run commandName --params`

- composer show durmus-aydogdu/laravel-resource
   
       php artisan composer:run show --param=durmus-aydogdu/laravel-resource
          
- composer show durmus-aydogdu/laravel-resource
   
       php artisan composer:run show --params=durmus-aydogdu/laravel-resource
                        
- composer search durmus-aydogdu/laravel-resource

       php artisan composer:run search --params=durmus-aydogdu/laravel-resource