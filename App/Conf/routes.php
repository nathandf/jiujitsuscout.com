<?php

// routes
$Router->add( "", [ "controller" => "home", "action" => "index" ] );
$Router->add( "{action}", [ "controller" => "home" ] );

// Blogging engine routes
$Router->add( "{blogurl:blog}/", [ "controller" => "blog", "action" => "index" ] );
$Router->add( "{blogurl:blog}/{article:[a-zA-Z0-9-]*}", [ "controller" => "blog", "action" => "article" ] );
$Router->add( "{blogurl:blog}/{taxonomy:[a-zA-Z0-9-]+}/", [ "controller" => "blog", "action" => "taxonomy" ] );
$Router->add( "{blogurl:blog}/{taxonomy:[a-zA-Z0-9-]+}/{taxon:[a-zA-Z0-9-]+}/", [ "controller" => "blog", "action" => "taxon" ] );
$Router->add( "{blogurl:blog}/{taxonomy:[a-zA-Z0-9-]+}/{taxon:[a-zA-Z0-9-]+}/{article:[a-zA-Z0-9-]+}", [ "controller" => "blog", "action" => "article" ] );
$Router->add( "{blogurl:blog}/{year:[0-9][0-9][0-9][0-9]}/{monthnum:[0-9][0-9]}/{day:[0-9][0-9]}/{article:[a-zA-Z0-9-]*}", [ "controller" => "blog", "action" => "date" ] );

$Router->add( "{blogurl:martial-arts-business-blog}/", [ "controller" => "blog", "action" => "index" ] );
$Router->add( "{blogurl:martial-arts-business-blog}/{article:[a-zA-Z0-9-]*}", [ "controller" => "blog", "action" => "article" ] );
$Router->add( "{blogurl:martial-arts-business-blog}/{taxonomy:[a-zA-Z0-9-]+}/", [ "controller" => "blog", "action" => "taxonomy" ] );
$Router->add( "{blogurl:martial-arts-business-blog}/{taxonomy:[a-zA-Z0-9-]+}/{taxon:[a-zA-Z0-9-]+}/", [ "controller" => "blog", "action" => "taxon" ] );
$Router->add( "{blogurl:martial-arts-business-blog}/{taxonomy:[a-zA-Z0-9-]+}/{taxon:[a-zA-Z0-9-]+}/{article:[a-zA-Z0-9-]+}", [ "controller" => "blog", "action" => "article" ] );
$Router->add( "{blogurl:martial-arts-business-blog}/{year:[0-9][0-9][0-9][0-9]}/{monthnum:[0-9][0-9]}/{day:[0-9][0-9]}/{article:[a-zA-Z0-9-]*}", [ "controller" => "blog", "action" => "date" ] );

// Discipline routes
$Router->add( "{controller:disciplines}/", [ "action" => "index" ] );
$Router->add( "{controller:disciplines}/{discipline:[a-zA-Z0-9-]+}/", [ "action" => "discipline" ] );
$Router->add( "{controller:disciplines}/{discipline:[a-zA-Z0-9-]+}/{action:near-me}/" );

// Martial arts profile routes
$Router->add( "{path:martial-arts-gyms}/{controller:near-me}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:martial-arts-gyms}/{controller:near-me}/{region:[a-zA-Z-]+[0-9]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:martial-arts-gyms}/{controller:near-me}/{region:[a-zA-Z-]+[0-9]*}/{locality:[a-zA-Z-]+[0-9]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{region:[a-zA-Z-]+[0-9]*}/{locality:[a-zA-Z-]+[0-9]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{region:[a-zA-Z-]+[0-9]*}/{locality:[a-zA-Z-]+[0-9]*}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{region:[a-zA-Z-]+[0-9]*}/{locality:[a-zA-Z-]+[0-9]*}/{siteslug:[a-zA-Z0-9-]*}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}/{slug:[a-zA-Z0-9-]+}" );
$Router->add( "{path:martial-arts-gyms}/{id:[0-9]+}/promo/{slug:[a-zA-Z0-9-]+}/{action:[a-zA-Z0-9-]+}", [ "controller" => "landing-page-capture" ] );
$Router->add( "{controller:martial-arts-gyms}/{siteslug:[a-zA-Z0-9-]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{controller:martial-arts-gyms}/{siteslug:[a-zA-Z0-9-]+}/{action:[a-zA-Z0-9-]*}/{slug:[a-zA-Z0-9-]+}" );

$Router->add( "{path:jjs-admin}/{controller:blog}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:jjs-admin/blog}/{blogid:[0-9]+}/{controller:article}/{articleid:[0-9]+}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:jjs-admin}/{controller:business}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );

$Router->add( "{path:[a-zA-Z0-9-/]+}/{controller:[a-zA-Z0-9-]*}/{id:[0-9]+}/{action:[a-zA-Z0-9-]*}" );

// Form submission route
$Router->add( "{controller:form*}/{token:[a-zA-Z0-9-]+}/{action:[a-zA-Z0-9-]*}" );

$Router->add( "{controller}/{action:[a-zA-Z0-9-]*}" );
$Router->add( "{path:[a-zA-Z0-9-/]+}/{controller}/{action:[a-zA-Z0-9-]*}" );
