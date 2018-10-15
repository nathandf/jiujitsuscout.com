<?php

// routes
$Router->add( "", [ "controller" => "home", "action" => 'index' ] );
$Router->add( "{action}", [ "controller" => "home" ] );
$Router->add( "{path:martial-arts-gyms}/{controller:near-me}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:martial-arts-gyms}/{controller:near-me}/{region:[a-zA-Z0-9-]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:martial-arts-gyms}/{controller:near-me}/{region:[a-zA-Z0-9-]*}/{locality:[a-zA-Z0-9-]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{locality:[a-zA-Z0-9-]*}/{region:[a-zA-Z0-9-]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{locality:[a-zA-Z0-9-]*}/{region:[a-zA-Z0-9-]*}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{locality:[a-zA-Z0-9-]*}/{region:[a-zA-Z0-9-]*}/{siteslug:[a-zA-Z0-9-]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}/{slug:[a-zA-Z0-9-]+}" );
$Router->add( "{controller:martial-arts-gyms}/{siteslug:[a-zA-Z0-9-]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{siteslug:[a-zA-Z0-9-]+}/{action:[a-zA-Z0-9-]*}/{slug:[a-zA-Z0-9-]+}" );
$Router->add( "{path:account-manager/business}/{controller:lead}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:appointment}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:trial}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:member}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:landing-page}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:group}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:campaign}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:task}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/business}/{controller:schedule}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:account-manager/settings}/{controller:user}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:jjs-admin}/{controller:business}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:[a-zA-Z0-9-/]+}/{controller}/{action:[a-zA-Z0-9-]*}" );
