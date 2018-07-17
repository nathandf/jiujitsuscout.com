<?php
/*
* Services and dependency injection on instanciation
*/

$container->register( "config", function() {
	$config = new Conf\Config;
	return $config;
} );

$container->register( "error", function() use ( $container ) {
	$error = new Core\Error( $container );
	return $error;
} );

$container->register( "session", function() {
    $session = new Core\Session;
    return $session;
} );

$container->register( "view", function() use( $container ) {
	$view = new Core\View( $container );
	return $view;
} );

$container->register( "smarty", function() {
	$smarty = new Smarty();
	return $smarty;
} );

$container->register( "templating-engine", function() use ( $container ) {
	$templatingEngine = $container->getService( "smarty" );
	return $templatingEngine;
} );

// Database access object

$container->register( "pdo", function() use ( $container ) {
	$conf = $container->getService( "config" );
	$pdo = new \PDO(
		"mysql:host={$conf::$configs[ "db" ][ "{$conf::getEnv()}" ][ "host" ]}; dbname={$conf::$configs[ "db" ][ "{$conf::getEnv()}" ][ "dbname" ]};",
		$conf::$configs[ "db" ][ "{$conf::getEnv()}" ][ "user" ],
		$conf::$configs[ "db" ][ "{$conf::getEnv()}" ][ "password" ]
	);
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	return $pdo;
} );

$container->register( "dao", function() use ( $container ) {
	$databaseAccessObject = $container->getService( "pdo" );
	return $databaseAccessObject;
} );

// Services

$container->register( "transaction-builder", function() use ( $container ) {
	$transactionBuilder = new \Models\Services\TransactionBuilder( $container->getService( "product-repository" ) );
	return $transactionBuilder;
} );

$container->register( "entity-factory", function() {
	$factory = new \Models\Services\EntityFactory;
	return $factory;
} );

$container->register( "account-repository", function() use ( $container ) {
	$repo = new \Models\Services\AccountRepository( $container );
	return $repo;
} );

$container->register( "account-type-repository", function() use ( $container ) {
	$repo = new \Models\Services\AccountTypeRepository( $container );
	return $repo;
} );

$container->register( "account-user-repository", function() use ( $container ) {
	$repo = new \Models\Services\AccountUserRepository( $container );
	return $repo;
} );

$container->register( "appointment-repository", function() use ( $container ) {
	$repo = new \Models\Services\AppointmentRepository( $container );
	return $repo;
} );

$container->register( "business-repository", function() use ( $container ) {
	$repo = new \Models\Services\BusinessRepository( $container );
	return $repo;
} );

$container->register( "campaign-repository", function() use ( $container ) {
	$repo = new \Models\Services\CampaignRepository( $container );
	return $repo;
} );

$container->register( "campaign-type-repository", function() use ( $container ) {
	$repo = new \Models\Services\CampaignTypeRepository( $container );
	return $repo;
} );

$container->register( "country-repository", function() use ( $container ) {
	$repo = new \Models\Services\CountryRepository( $container );
	return $repo;
} );

$container->register( "course-repository", function() use ( $container ) {
	$repo = new \Models\Services\CourseRepository( $container );
	return $repo;
} );

$container->register( "course-schedule-repository", function() use ( $container ) {
	$repo = new \Models\Services\CourseScheduleRepository( $container );
	return $repo;
} );

$container->register( "currency-repository", function() use ( $container ) {
	$repo = new \Models\Services\CurrencyRepository( $container );
	return $repo;
} );

$container->register( "discipline-repository", function() use ( $container ) {
	$repo = new \Models\Services\DisciplineRepository( $container );
	return $repo;
} );

$container->register( "email-repository", function() use ( $container ) {
	$repo = new \Models\Services\EmailRepository( $container );
	return $repo;
} );

$container->register( "event-email-repository", function() use ( $container ) {
	$repo = new \Models\Services\EventEmailRepository( $container );
	return $repo;
} );

$container->register( "event-repository", function() use ( $container ) {
	$repo = new \Models\Services\EventRepository( $container );
	return $repo;
} );

$container->register( "event-text-message-repository", function() use ( $container ) {
	$repo = new \Models\Services\EventTextMessageRepository( $container );
	return $repo;
} );

$container->register( "event-type-repository", function() use ( $container ) {
	$repo = new \Models\Services\EventTypeRepository( $container );
	return $repo;
} );

$container->register( "group-repository", function() use ( $container ) {
	$repo = new \Models\Services\GroupRepository( $container );
	return $repo;
} );

$container->register( "landing-page-repository", function() use ( $container ) {
	$repo = new \Models\Services\LandingPageRepository( $container );
	return $repo;
} );

$container->register( "landing-page-template-repository", function() use ( $container ) {
	$repo = new \Models\Services\LandingPageTemplateRepository( $container );
	return $repo;
} );

$container->register( "member-repository", function() use ( $container ) {
	$repo = new \Models\Services\MemberRepository( $container );
	return $repo;
} );

$container->register( "nonce-token-repository", function() use ( $container ) {
	$repo = new \Models\Services\NonceTokenRepository( $container );
	return $repo;
} );

$container->register( "note-repository", function() use ( $container ) {
	$repo = new \Models\Services\NoteRepository( $container );
	return $repo;
} );

$container->register( "password-reset-repository", function() use ( $container ) {
	$repo = new \Models\Services\PasswordResetRepository( $container );
	return $repo;
} );

$container->register( "phone-repository", function() use ( $container ) {
	$repo = new \Models\Services\PhoneRepository( $container );
	return $repo;
} );

$container->register( "product-repository", function() use ( $container ) {
	$repo = new \Models\Services\ProductRepository( $container );
	return $repo;
} );

$container->register( "program-repository", function() use ( $container ) {
	$repo = new \Models\Services\ProgramRepository( $container );
	return $repo;
} );

$container->register( "prospect-repository", function() use ( $container ) {
	$repo = new \Models\Services\ProspectRepository( $container );
	return $repo;
} );

$container->register( "review-repository", function() use ( $container ) {
	$repo = new \Models\Services\ReviewRepository( $container );
	return $repo;
} );

$container->register( "result-repository", function() use ( $container ) {
	$repo = new \Models\Services\ResultRepository( $container );
	return $repo;
} );

$container->register( "schedule-repository", function() use ( $container ) {
	$repo = new \Models\Services\ScheduleRepository( $container );
	return $repo;
} );

$container->register( "search-repository", function() use ( $container ) {
	$repo = new \Models\Services\SearchRepository( $container );
	return $repo;
} );

$container->register( "sequence-repository", function() use ( $container ) {
	$repo = new \Models\Services\SequenceRepository( $container );
	return $repo;
} );

$container->register( "sms-message-repository", function() use ( $container ) {
	$repo = new \Models\Services\SMSMessageRepository( $container );
	return $repo;
} );

$container->register( "task-repository", function() use ( $container ) {
	$repo = new \Models\Services\TaskRepository( $container );
	return $repo;
} );

$container->register( "text-message-repository", function() use ( $container ) {
	$repo = new \Models\Services\TextMessageRepository( $container );
	return $repo;
} );

$container->register( "user-repository", function() use ( $container ) {
	$repo = new \Models\Services\UserRepository( $container );
	return $repo;
} );

$container->register( "user-authenticator", function() use ( $container ) {
	$userService = new \Models\Services\UserAuthenticator(
	    $container->getService( "user-repository" )
    );
	return $userService;
} );

$container->register( "user-registrar", function() use ( $container ) {
	$registrar = new \Models\Services\UserRegistrar(
		$container->getService( "user-repository" ),
		$container->getService( "account-user-repository" ),
		$container->getService( "user-mailer" ) );
	return $registrar;
} );

$container->register( "account-registrar", function() use ( $container ) {
	$registrar = new \Models\Services\AccountRegistrar( $container->getService( "account-repository" ) );
	return $registrar;
} );

$container->register( "business-registrar", function() use ( $container ) {
	$registrar = new \Models\Services\BusinessRegistrar(
		$container->getService( "business-repository" ),
		$container->getService( "group-repository" ),
		$container->getService( "phone-repository" )
	 );
	return $registrar;
} );

$container->register( "member-registrar", function() use ( $container ) {
	$registrar = new \Models\Services\MemberRegistrar(
		$container->getService( "member-repository" )
	);
	return $registrar;
} );

$container->register( "prospect-registrar", function() use ( $container ) {
	$registrar = new \Models\Services\ProspectRegistrar(
		$container->getService( "prospect-repository" ),
		$container->getService( "entity-factory" )
	 );
	return $registrar;
} );

$container->register( "note-registrar", function() use ( $container ) {
	$registrar = new \Models\Services\NoteRegistrar(
		$container->getService( "note-repository" ),
		$container->getService( "entity-factory" )
	);
	return $registrar;
} );

$container->register( "sendgrid-mailer", function() use ( $container ) {
	$sendGridMailer = new \Models\Services\SendGridMailer( $container->getService( "config" ) );
	return $sendGridMailer;
} );

$container->register( "mailer", function() use ( $container ) {
	$mailerService = $container->getService( "sendgrid-mailer" );
	return $mailerService;
} );

$container->register( "user-mailer", function() use ( $container ) {
	$mailerService = new \Models\Services\UserMailer(
		$container->getService( "mailer" ),
		$container->getService( "config" )
	);
	return $mailerService;
} );

$container->register( "sales-agent-mailer", function() use ( $container ) {
	$mailerService = new \Models\Services\SalesAgentMailer( $container->getService( "mailer" ) );
	return $mailerService;
} );

$container->register( "twilio-sms-messager", function() {
	$twilioMessager = new \Models\Services\TwilioSMSMessager;
	return $twilioMessager;
} );

$container->register( "sms-messager", function() use ( $container ) {
	$smsMessager = $container->getService( "twilio-sms-messager" );
	return $smsMessager;
} );

// Helpers

$container->register( "form", function() {
	$form = new \Helpers\Form;
	return $form;
} );

$container->register( "form-validator", function() {
	$formValidator = new \Helpers\FormValidator;
	return $formValidator;
} );

$container->register( "input", function() {
    $obj = new \Helpers\Input;
    return $obj;
} );

$container->register( "input-validator", function() {
    $obj = new \Helpers\InputValidator;
    return $obj;
} );

$container->register( "google-geocoder", function() use ( $container ) {
	$GoogleGeocoder = new \Helpers\GoogleGeocoder( $container->getService( "config" ) );
	return $GoogleGeocoder;
} );

$container->register( "geocoder", function() use ( $container ) {
	$Geocoder = $container->getService( "google-geocoder" );
	return $Geocoder;
} );

$container->register( "geometry", function() use ( $container ) {
	$Geometry = new \Helpers\Geometry;
	return $Geometry;
} );

$container->register( "ip-info", function() use ( $container ) {
	$IPInfo = new \Helpers\IPInfo( $container->getService( "config" ) );
	return $IPInfo;
} );

$container->register( "timezonedb", function() use ( $container ) {
	$Timezonedb = new \Helpers\Timezonedb( $container->getService( "config" ) );
	return $Timezonedb;
} );

$container->register( "time-manager", function() {
	$timeManager = new \Helpers\TimeManager;
	return $timeManager;
} );

$container->register( "access-control", function() {
	$accessControl = new \Helpers\AccessControl;
	return $accessControl;
} );

$container->register( "image-manager", function() {
	$imageManager = new \Helpers\ImageManager;
	return $imageManager;
} );

// Quarantine

$container->register( "paypal-api-initializer", function() use ( $container ) {
	$pp_initializer = new \Models\Services\PayPalAPIInitializer( $container->getService( "config" ) );
	return $pp_initializer;
} );

$container->register( "facebook-api-initializer", function() use ( $container ) {
	$fb_initializer = new \Models\Services\FacebookAPIInitializer( $container->getService( "config" ) );
	return $fb_initializer;
} );

$container->register( "facebook-login", function() use ( $container ) {
	$fb_login = new \Models\Services\FacebookLogin( $container->getService( "facebook-api-initializer" ) );
	return $fb_login;
} );

$container->register( "paypal-payment-manager", function() use ( $container ) {
	$paymentManager = new \Models\Services\PayPalPaymentManager( $container->getService( "paypal-api-initializer" ) );
	return $paymentManager;
} );

$container->register( "payment-manager", function() use ( $container ) {
	$paymentManager = $container->getService( "paypal-payment-manager" );
	return $paymentManager;
} );

$container->register( "sequence-dispatcher", function() use ( $container ) {
	$manager = new \Models\Services\SequenceManager(
		$container->getService( "sequence-repository" ),
		$container->getService( "event-dispatcher" )
	);
	return $manager;
} );

$container->register( "event-email-dispatcher", function() use ( $container ) {
	$manager = new \Models\Services\EventEmailDispatcher(
		$container->getService( "event-email-repository" ),
		$container->getService( "email-repository" ),
		$container->getService( "mailer" )
	);
	return $manager;
} );

$container->register( "event-text-message-dispatcher", function() use ( $container ) {
	$manager = new \Models\Services\EventTextMessageDispatcher(
		$container->getService( "event-text-message-repository" ),
		$container->getService( "text-message-repository" ),
		$container->getService( "sms-messager" )
	);
	return $manager;
} );

$container->register( "event-dispatcher", function() use ( $container ) {
	$manager = new \Models\Services\EventDispatcher(
		$container->getService( "event-repository" ),
		$container->getService( "event-email-dispatcher" ),
		$container->getService( "event-text-message-dispatcher" )
	);
	return $manager;
} );
