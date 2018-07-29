<?php

$config[ "sitemap_base_url" ] = "https://www.jiujitsuscout.com/";
$config[ "sitemap_ignore" ] = [ "sitemap.xml", "account-manager/user/logout", "jjs-admin/logout", "test" ];
$config[ "facebook" ][ "pixel_id" ] = '1842001532752101';
$config[ "max_upload_filesize" ] = "2MB";
$config[ "default_logo" ] = "jjslogoiconwhite.jpg";

// Logging
$config[ "logs_directory" ] = "App/logs/";

// Email Settings
$config[ "email_settings" ] = [
    "development" => [
        "url_prefix" => "http://localhost/jiujitsuscout.com/"
    ],
    "staging" => [
        "url_prefix" => "http://develop.jiujitsuscout.stupidsimple.tech/"
    ],
    "production" => [
        "url_prefix" => "https://jiujitsuscout.com/"
    ],
];

// Database
$config[ "db" ] = [
    "development" => [
        "host" => "localhost",
        "dbname" => "yurigloc_jjs_development",
        "user" => "yurigloc_develop",
        "password" => "Q7Np4WBUfCveynAy",
    ],
    "staging" => [
        "host" => "localhost",
        "dbname" => "jjs_main",
        "user" => "jjspartner",
        "password" => "Q7Np4WBUfCveynAy",
    ],
    "production" => [
        "host" => "localhost",
        "dbname" => "yurigloc_jjs_main",
        "user" => "yurigloc_main",
        "password" => "XHN8yxNzpN2l",
    ]
];

// Google APIs
$config[ "google" ] = [
    "api_key" => "AIzaSyAROndVkrCCoOGb2GDL5h9kuu9YF8zhHoM",
    "geocoding_api" => [
        "gateway" => "https://maps.google.com/maps/api/geocode/json"
    ]
];

// Nexmo API
$config[ "nexmo" ] = [
    "api_key" => "6a3643ad",
    "api_secret" => "d469863bf500dafd",
    "nexmo_number" => "12092835526",
    "base_url" => "https://rest.nexmo.com/sms/json?",
    "default_country" => "US",
    "default_country_code" => "1"
];

// SendGrid API
$config[ "sendgrid" ] = [
  "api_key" => "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"
];

// Twilio API
$config[ "twilio" ] = [
    "twilio_primary_number" => "+18327569315",
    "twilio_account_sid" => "AC3d93be2edcbca441047413b94b2dc0f2",
    "twilio_auth_token" => "8ed2a4adecc920d870cd605464bd5bf4"
];

// PayPal API
$config[ "paypal" ] = [
    "api" => [
        "credentials" => [
            "sandbox" => [
                "client_id" => "AT4dpyjz2EQIXfsqYWqBSaUc87s95p-ry7xN18WvDpjrBpdk_nJc5ZuACkMoXMTJYVDn9S3qvgxPZuT1",
                "client_secret" => "EDh0pK-DyJL7psap_59pmkAJJ4ZB9Xmb0Td75C3JcesqsvG7so6Ym3a7J0DN-K8WlcBoMYT0fQVHAD3L"
            ],
            "live" => [
                "client_id" => "Adhn5LLW3XNFdYRNZamNvkhh82XT5_hLCUsUjXArK5WmZ3VjhGd3OVWqt5Plmw02Q-I-c_Wb6pwynO47",
                "client_secret" => "EEe-Ep-7OTWlqdeYW1NTRLCJl3GX5-cfJ-ZuTKo4WXM3gyJA24dLTdPMtNud6kIuKZnXpkDvE4mPLzES"
            ]
        ],

        "log_filename" => "logs/paypal-transactions.txt"
    ],
];

$config[ "braintree" ] = [
    "environment" => "sandbox",
    "credentials" => [
        "merchant_id" => "kkbwf4n39k6swp8g",
        "public_key" => "3mjf86zmfkgyczzh",
        "private_key" => "1426beef3362529e126a9dc67a76a8da",
        "tokenization_key" => "sandbox_vn2nhygr_kkbwf4n39k6swp8g"
    ]
];

// IPInfo API
$config[ "ipinfo" ] = [
    "access_token" => "3bc3b475674965",
];

$config[ "timezonedb" ] = [
    "gateway" => "http://vip.timezonedb.com/v2/",
    "api_key" => "E6XZG3WR9YUH"
];

// Facebook
$config[ "facebook" ] = [
    "api" => [
        "development" => [
            "app_id" => "442958592716305",
            "app_secret" => "8443065fb8cbf6ba955cdd73eff0ed2f",
            "login_url" => "http://localhost/develop.jiujitsuscout.com/callbacks/facebook/login"
        ],
        "production" => [
            "app_id" => "442865139392317",
            "app_secret" => "9b5cbd71e79fc5a800ac448c5893f808",
            "login_url" => "https://www.jiujitsuscout.com/callbacks/facebook/login"
        ],
        "default_graph_version" => "v5.6"
    ],
    "jjs_client_pixel_id" => "309803832759430"
];
