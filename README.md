PayU SDK for Laravel
=======================
Laravel integration of the [PayU PHP SDK](https://github.com/jlorente/payu-php-sdk).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require jlorente/laravel-payu
```

or add 

```json
...
    "require": {
        "jlorente/laravel-payu": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

1. Register the ServiceProvider in your config/app.php service provider list.

config/app.php
```php
return [
    //other stuff
    'providers' => [
        //other stuff
        \Jlorente\Laravel\PayU\PayUServiceProvider::class,
    ];
];
```

2. Add the following facade to the $aliases section.

config/app.php
```php
return [
    //other stuff
    'aliases' => [
        //other stuff
        'PayU' => \Jlorente\Laravel\PayU\Facades\PayU::class,
    ];
];
```

3. Publish the package configuration file.

```bash
$ php artisan vendor:publish --provider='Jlorente\Laravel\PayU\PayUServiceProvider'
```

4. Set the api_key and api_secret in the config/payu.php file or use the predefined env 
variables.

config/payu.php
```php
return [
    'api_key' => 'YOUR_API_KEY',
    'api_login' => 'YOUR_API_LOGIN',
    'merchant_id' => 'YOUR_MERCHANT_ID',
    'language' => 'YOUR_LANGUAGE' // Currently 'en, 'es', 'pt (default 'es')
    'is_test' => 'YOUR_IS_TEST' // true or false
    //other configuration
];
```
or 
.env
```
//other configurations
PAYU_API_KEY=<YOUR_API_KEY>
PAYU_API_LOGIN=<YOUR_API_LOGIN>
PAYU_MERCHANT_ID=<YOUR_MERCHANT_ID>
PAYU_LANGUAGE=<YOUR_LANGUAGE>
PAYU_IS_TEST=<YOUR_IS_TEST>
```

## Usage

You can use the facade alias PayU to execute the PHP SDK methods through their 
classes. Note that the class name PayU prefix should be avoided.

```php
PayU::tokens()::create($params);
PayU::payments()::doAuthorizationAndCapture($params);
PayU::reports()::getOrderDetail($parameters);
```

The authentication params will be automaticaly injected.

## License 
Copyright &copy; 2020 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the BSD 3-Clause License. See LICENSE.txt for details.
