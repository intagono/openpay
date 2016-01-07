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

    /*
    | Enable the use of database for Holders, Cards & Bank Accounts
    */
    'database' => false,
];