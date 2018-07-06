<?php

define( "DS", "/" ); // Directory seperator
// constants REL and HOME defined in the router class

// site info
define( 'SITE_PRETTY', 'JiuJitsuScout.com' );
define( 'SITE', 'jiujitsuscout.com' );
define( 'EMAIL', 'jiujitsuscout@gmail.com' );
define( 'PHONE_NUMBER', '(346) 800-7989' );

// resources **NOTE** Always end the path to the resources with a forward slash
define( "CONFIGS", "config/" );
define( "JS_SCRIPTS", "App/scripts/js/" );
define( "PHP_SCRIPTS", "App/scripts/php/" );
define( "MODELS", "App/models/" );
define( "VIEWS", "App/Views/" );
define( "TEMPLATES", VIEWS . "templates/" );
define( "LANDING_PAGE_TEMPLATES", TEMPLATES . "landing-page-templates/" );
define( "TRACKING_CODES", TEMPLATES . "includes/tracking-codes/" );
define( "CONTROLLERS", "App/controllers/" );

define( "LIBRARIES", "App/vendor/" );
define( "HELPERS", "App/Helpers/" );

// time
define( "YEAR", date( 'Y' ) );
define( "TODAY",  date( 'Y-m-d' ) );

// user
define( 'USER_IP', $_SERVER[ "REMOTE_ADDR" ] );
