<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'image_kit' => [
        'public_key' => env('IMAGE_KIT_PUBLIC_KEY'),
        'private_key' => env('IMAGE_KIT_PRIVATE_KEY'),
        'endpoint' => env('IMAGE_KIT_URL_ENDPOINT'),
    ],

    'mango_pay' => [
        'client_id' => env('MANGO_PAY_CLIENT_ID'),
        'client_password' => env('MANGO_PAY_CLIENT_PASSWORD'),
        'base_url'=>env('MANGO_PAY_BASE_URL'),
    ],

    'mango_pay_config'=>
    [
        'id'=>env('ESCROW_ID' , '208886033'),
        'wallet'=>env('ESCROW_WALLET_ID' ,'208886176'),
        'comission_id'=>env('COMISSION_ID' ,'209069295'),
        'comission_wallet_id'=>env('COMISSION_WALLET_ID' ,'209070179'),
        'currency'=>env('MANGOPAY_CURRENCY','GBP'),
    ],

    'recaptcha' => [
        'key' => env('GOOGLE_CAPTCHA_SITEKEY'),
    ],

    'zendesk' => [
        'subdomain' => env('ZENDESK_SUBDOMAIN'),
        'username' => env('ZENDESK_USERNAME'),
        'token' => env('ZENDESK_API_TOKEN'),
    ],
 
    'mail' => [
        'from_address' => env('MAIL_FROM_ADDRESS'),
        'from_name' => env('MAIL_FROM_NAME'),
    ],

    'general' => [
        'currency' => env('CURRENCY', '£'),
        'location_api_key' => env('IP_LOCATION_API_KEY'),
    ],
    

];
