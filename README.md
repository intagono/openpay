# Openpay

Library that simplifies the process of [OpenPay Payment Gateway Api](http://www.openpay.mx/)

## Installation

Begin by installing this package through Composer.

```js
{
    "require": {
        "intagono/openpay": "dev-master"
    }
}
```

## Laravel 5

Register the following Service Provider and Alias

```php
// config/app.php

'providers' => [
    Intagono\Openpay\OpenpayServiceProvider::class,
];

'aliases' => [
    'IntagonoOpenpay' => Intagono\Openpay\OpenpayFacade::class,
];
```

Then, publish the default configuration.

```bash
php artisan vendor:publish
```

This will add a new configuration file to: `config/openpay.php`.
You will need to create these variables in your .env file with the appropriate values.

```php
<?php

return [

    /*
    | (Boolean) Determines if Openpay is running in production mode.
    */
    'production_mode' => env('OPENPAY_PRODUCTION_MODE'),

    /*
    | Your Merchant ID, found in Openpay Dashboard -- Configuration.
    */
    'merchant_id' => env('OPENPAY_MERCHANT_ID'),

    /*
    | Your Private Key, found in Openpay Dashboard -- Configuration.
    */
    'private_key' => env('OPENPAY_PRIVATE_KEY'),
];
```

If you want to handle all Openpay Exceptions in one same place, use the following trait in your Exception Handler and modify the render method.

```php
// app/Exceptions/Handler.php

use Intagono\Openpay\OpenpayExceptionTrait;

class Handler extends ExceptionHandler {

    use OpenPayExceptionTrait;

    ...

    public function render($request, Exception $e)
    {
        if ($this->isOpenPayException($e))
        {
            return $this->renderOpenPayException($request, $e);
        }
        else
        {
            return parent::render($request, $e);
        }
    }

}
```

By default, this trait will catch all Openpay Exceptions and will redirect back with input and the error message. In case of ajax it will return a response with the error message.

### Usage

Constructor Injection.

```php
<?php

use Intagono\Openpay\Openpay;

class Foo {

    /**
     * @var \Intagono\Openpay\Openpay
     */
    protected $openpay;

    /**
     * Constructor
     */
    public function __construct(Openpay $openpay)
    {
        $this->openpay = $openpay;
    }

}
```

Facade

```php
<?php

class Bar {

    public function Baz()
    {
        $charge = IntagonoOpenpay::charge($chargeRequest);
    }

}
```

## Outside Laravel

`Intagono\Openpay\Openpay` has a dependency in the Openpay core.

```php
require 'vendor/autoload.php';

$openpayCore = \Openpay::getInstance($merchantId, $privayeKey);

$intagonoOpenpay = new \Intagono\Openpay\Openpay($openpayCore);
```