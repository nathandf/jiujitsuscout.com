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

$container->register( "logger", function() use ( $container ) {
	$Config = $container->getService( "config" );
	$logsDir = $Config::$configs[ "logs_directory" ];
	$logger = new Katzgrau\KLogger\Logger( $logsDir );
	return $logger;
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
	$transactionBuilder = new \Model\Services\TransactionBuilder(
		$container->getService( "transaction-repository" ),
		$container->getService( "order-repository" ),
		$container->getService( "order-product-repository" ),
		$container->getService( "product-repository" ),
		$container->getService( "customer-repository" ),
		$container->getService( "currency-repository" )
	);
	return $transactionBuilder;
} );

$container->register( "entity-factory", function() {
	$factory = new \Model\Services\EntityFactory;
	return $factory;
} );

$container->register( "account-repository", function() use ( $container ) {
	$repo = new \Model\Services\AccountRepository( $container );
	return $repo;
} );

$container->register( "account-type-repository", function() use ( $container ) {
	$repo = new \Model\Services\AccountTypeRepository( $container );
	return $repo;
} );

$container->register( "account-user-repository", function() use ( $container ) {
	$repo = new \Model\Services\AccountUserRepository( $container );
	return $repo;
} );

$container->register( "appointment-repository", function() use ( $container ) {
	$repo = new \Model\Services\AppointmentRepository( $container );
	return $repo;
} );

$container->register( "appointment-hash-repository", function() use ( $container ) {
	$repo = new \Model\Services\AppointmentHashRepository( $container );
	return $repo;
} );

$container->register( "braintree-api-manager", function() use ( $container ) {
	$transactionBuilder = new \Model\Services\BraintreeAPIManager(
		$container->getService( "braintree-gateway-initializer" )
	);
	return $transactionBuilder;
} );

$container->register( "braintree-transaction-repository", function() use ( $container ) {
	$repo = new \Model\Services\BraintreeTransactionRepository( $container );
	return $repo;
} );

$container->register( "business-repository", function() use ( $container ) {
	$repo = new \Model\Services\BusinessRepository( $container );
	return $repo;
} );

$container->register( "campaign-repository", function() use ( $container ) {
	$repo = new \Model\Services\CampaignRepository( $container );
	return $repo;
} );

$container->register( "campaign-type-repository", function() use ( $container ) {
	$repo = new \Model\Services\CampaignTypeRepository( $container );
	return $repo;
} );

$container->register( "click-repository", function() use ( $container ) {
	$repo = new \Model\Services\ClickRepository( $container );
	return $repo;
} );

$container->register( "country-repository", function() use ( $container ) {
	$repo = new \Model\Services\CountryRepository( $container );
	return $repo;
} );

$container->register( "course-repository", function() use ( $container ) {
	$repo = new \Model\Services\CourseRepository( $container );
	return $repo;
} );

$container->register( "course-schedule-repository", function() use ( $container ) {
	$repo = new \Model\Services\CourseScheduleRepository( $container );
	return $repo;
} );

$container->register( "currency-repository", function() use ( $container ) {
	$repo = new \Model\Services\CurrencyRepository( $container );
	return $repo;
} );

$container->register( "customer-braintree-customer-repository", function() use ( $container ) {
	$repo = new \Model\Services\CustomerBraintreeCustomerRepository( $container );
	return $repo;
} );

$container->register( "customer-repository", function() use ( $container ) {
	$repo = new \Model\Services\CustomerRepository( $container );
	return $repo;
} );

$container->register( "discipline-repository", function() use ( $container ) {
	$repo = new \Model\Services\DisciplineRepository( $container );
	return $repo;
} );

$container->register( "email-repository", function() use ( $container ) {
	$repo = new \Model\Services\EmailRepository( $container );
	return $repo;
} );

$container->register( "event-email-repository", function() use ( $container ) {
	$repo = new \Model\Services\EventEmailRepository( $container );
	return $repo;
} );

$container->register( "event-repository", function() use ( $container ) {
	$repo = new \Model\Services\EventRepository( $container );
	return $repo;
} );

$container->register( "event-text-message-repository", function() use ( $container ) {
	$repo = new \Model\Services\EventTextMessageRepository( $container );
	return $repo;
} );

$container->register( "event-type-repository", function() use ( $container ) {
	$repo = new \Model\Services\EventTypeRepository( $container );
	return $repo;
} );

$container->register( "faq-repository", function() use ( $container ) {
	$repo = new \Model\Services\FAQRepository( $container );
	return $repo;
} );

$container->register( "faq-answer-repository", function() use ( $container ) {
	$repo = new \Model\Services\FAQAnswerRepository( $container );
	return $repo;
} );

$container->register( "group-repository", function() use ( $container ) {
	$repo = new \Model\Services\GroupRepository( $container );
	return $repo;
} );

$container->register( "image-repository", function() use ( $container ) {
	$repo = new \Model\Services\ImageRepository( $container );
	return $repo;
} );

$container->register( "landing-page-repository", function() use ( $container ) {
	$repo = new \Model\Services\LandingPageRepository( $container );
	return $repo;
} );

$container->register( "landing-page-template-repository", function() use ( $container ) {
	$repo = new \Model\Services\LandingPageTemplateRepository( $container );
	return $repo;
} );

$container->register( "member-repository", function() use ( $container ) {
	$repo = new \Model\Services\MemberRepository( $container );
	return $repo;
} );

$container->register( "nonce-token-repository", function() use ( $container ) {
	$repo = new \Model\Services\NonceTokenRepository( $container );
	return $repo;
} );

$container->register( "note-repository", function() use ( $container ) {
	$repo = new \Model\Services\NoteRepository( $container );
	return $repo;
} );

$container->register( "order-repository", function() use ( $container ) {
	$repo = new \Model\Services\OrderRepository( $container );
	return $repo;
} );

$container->register( "order-product-repository", function() use ( $container ) {
	$repo = new \Model\Services\OrderProductRepository( $container );
	return $repo;
} );

$container->register( "password-reset-repository", function() use ( $container ) {
	$repo = new \Model\Services\PasswordResetRepository( $container );
	return $repo;
} );

$container->register( "phone-repository", function() use ( $container ) {
	$repo = new \Model\Services\PhoneRepository( $container );
	return $repo;
} );

$container->register( "product-repository", function() use ( $container ) {
	$repo = new \Model\Services\ProductRepository( $container );
	return $repo;
} );

$container->register( "product-account-type-repository", function() use ( $container ) {
	$repo = new \Model\Services\ProductAccountTypeRepository( $container );
	return $repo;
} );

$container->register( "program-repository", function() use ( $container ) {
	$repo = new \Model\Services\ProgramRepository( $container );
	return $repo;
} );

$container->register( "prospect-repository", function() use ( $container ) {
	$repo = new \Model\Services\ProspectRepository( $container );
	return $repo;
} );

$container->register( "prospect-appraisal-repository", function() use ( $container ) {
	$repo = new \Model\Services\ProspectAppraisalRepository( $container );
	return $repo;
} );

$container->register( "prospect-purchase-repository", function() use ( $container ) {
	$repo = new \Model\Services\ProspectPurchaseRepository( $container );
	return $repo;
} );

$container->register( "question-choice-repository", function() use ( $container ) {
	$repo = new \Model\Services\QuestionChoiceRepository( $container );
	return $repo;
} );

$container->register( "question-choice-type-repository", function() use ( $container ) {
	$repo = new \Model\Services\QuestionChoiceTypeRepository( $container );
	return $repo;
} );

$container->register( "question-choice-weight-repository", function() use ( $container ) {
	$repo = new \Model\Services\QuestionChoiceWeightRepository( $container );
	return $repo;
} );

$container->register( "questionnaire-repository", function() use ( $container ) {
	$repo = new \Model\Services\QuestionnaireRepository( $container );
	return $repo;
} );

$container->register( "question-repository", function() use ( $container ) {
	$repo = new \Model\Services\QuestionRepository( $container );
	return $repo;
} );

$container->register( "respondent-repository", function() use ( $container ) {
	$repo = new \Model\Services\RespondentRepository( $container );
	return $repo;
} );

$container->register( "respondent-question-answer-repository", function() use ( $container ) {
	$repo = new \Model\Services\RespondentQuestionAnswerRepository( $container );
	return $repo;
} );

$container->register( "review-repository", function() use ( $container ) {
	$repo = new \Model\Services\ReviewRepository( $container );
	return $repo;
} );

$container->register( "result-repository", function() use ( $container ) {
	$repo = new \Model\Services\ResultRepository( $container );
	return $repo;
} );

$container->register( "schedule-repository", function() use ( $container ) {
	$repo = new \Model\Services\ScheduleRepository( $container );
	return $repo;
} );

$container->register( "search-repository", function() use ( $container ) {
	$repo = new \Model\Services\SearchRepository( $container );
	return $repo;
} );

$container->register( "search-results-dispatcher", function() use ( $container ) {
	$dispatcher = new \Model\Services\SearchResultsDispatcher(
		$container->getService( "account-repository" ),
		$container->getService( "business-repository" ),
		$container->getService( "review-repository" ),
		$container->getService( "discipline-repository" ),
		$container->getService( "geocoder" ),
		$container->getService( "geometry" ),
		$container->getService( "fa-stars" )
	);
	return $dispatcher;
} );

$container->register( "sequence-repository", function() use ( $container ) {
	$repo = new \Model\Services\SequenceRepository( $container );
	return $repo;
} );

$container->register( "sms-message-repository", function() use ( $container ) {
	$repo = new \Model\Services\SMSMessageRepository( $container );
	return $repo;
} );

$container->register( "task-repository", function() use ( $container ) {
	$repo = new \Model\Services\TaskRepository( $container );
	return $repo;
} );

$container->register( "text-message-repository", function() use ( $container ) {
	$repo = new \Model\Services\TextMessageRepository( $container );
	return $repo;
} );

$container->register( "transaction-repository", function() use ( $container ) {
	$repo = new \Model\Services\TransactionRepository( $container );
	return $repo;
} );

$container->register( "unsubscribe-repository", function() use ( $container ) {
	$repo = new \Model\Services\UnsubscribeRepository( $container );
	return $repo;
} );

$container->register( "user-repository", function() use ( $container ) {
	$repo = new \Model\Services\UserRepository( $container );
	return $repo;
} );

$container->register( "user-authenticator", function() use ( $container ) {
	$userService = new \Model\Services\UserAuthenticator(
	    $container->getService( "user-repository" )
    );
	return $userService;
} );

$container->register( "user-registrar", function() use ( $container ) {
	$registrar = new \Model\Services\UserRegistrar(
		$container->getService( "user-repository" ),
		$container->getService( "account-user-repository" ),
		$container->getService( "user-mailer" ) );
	return $registrar;
} );

$container->register( "account-registrar", function() use ( $container ) {
	$registrar = new \Model\Services\AccountRegistrar( $container->getService( "account-repository" ) );
	return $registrar;
} );

$container->register( "business-registrar", function() use ( $container ) {
	$registrar = new \Model\Services\BusinessRegistrar(
		$container->getService( "business-repository" ),
		$container->getService( "group-repository" ),
		$container->getService( "phone-repository" )
	 );
	return $registrar;
} );

$container->register( "member-registrar", function() use ( $container ) {
	$registrar = new \Model\Services\MemberRegistrar(
		$container->getService( "member-repository" )
	);
	return $registrar;
} );

$container->register( "prospect-registrar", function() use ( $container ) {
	$registrar = new \Model\Services\ProspectRegistrar(
		$container->getService( "prospect-repository" ),
		$container->getService( "entity-factory" )
	 );
	return $registrar;
} );

$container->register( "note-registrar", function() use ( $container ) {
	$registrar = new \Model\Services\NoteRegistrar(
		$container->getService( "note-repository" ),
		$container->getService( "entity-factory" )
	);
	return $registrar;
} );

$container->register( "sendgrid-mailer", function() use ( $container ) {
	$sendGridMailer = new \Model\Services\SendGridMailer( $container->getService( "config" ) );
	return $sendGridMailer;
} );

$container->register( "mailer", function() use ( $container ) {
	$mailerService = $container->getService( "sendgrid-mailer" );
	return $mailerService;
} );

$container->register( "user-mailer", function() use ( $container ) {
	$mailerService = new \Model\Services\UserMailer(
		$container->getService( "mailer" ),
		$container->getService( "config" )
	);
	return $mailerService;
} );

$container->register( "sales-agent-mailer", function() use ( $container ) {
	$mailerService = new \Model\Services\SalesAgentMailer( $container->getService( "mailer" ) );
	return $mailerService;
} );

$container->register( "twilio-sms-messager", function() {
	$twilioMessager = new \Model\Services\TwilioSMSMessager;
	return $twilioMessager;
} );

$container->register( "sms-messager", function() use ( $container ) {
	$smsMessager = $container->getService( "twilio-sms-messager" );
	return $smsMessager;
} );

// Helpers
$container->register( "access-control", function() {
	$helper = new \Helpers\AccessControl;
	return $helper;
} );

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

$container->register( "facebook-pixel-builder", function() {
	$helper = new \Helpers\FacebookPixelBuilder;
	return $helper;
} );

$container->register( "fa-stars", function() {
	$helper = new \Helpers\FAStars;
	return $helper;
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

// API Services

$container->register( "braintree-gateway-initializer", function() use ( $container ) {
	$initializer = new \Model\Services\BraintreeGatewayInitializer( $container->getService( "config" ) );
	return $initializer;
} );

$container->register( "paypal-api-initializer", function() use ( $container ) {
	$pp_initializer = new \Model\Services\PayPalAPIInitializer( $container->getService( "config" ) );
	return $pp_initializer;
} );

$container->register( "facebook-api-initializer", function() use ( $container ) {
	$fb_initializer = new \Model\Services\FacebookAPIInitializer( $container->getService( "config" ) );
	return $fb_initializer;
} );

$container->register( "facebook-login", function() use ( $container ) {
	$fb_login = new \Model\Services\FacebookLogin( $container->getService( "facebook-api-initializer" ) );
	return $fb_login;
} );

$container->register( "paypal-payment-manager", function() use ( $container ) {
	$paymentManager = new \Model\Services\PayPalPaymentManager( $container->getService( "paypal-api-initializer" ) );
	return $paymentManager;
} );

$container->register( "payment-manager", function() use ( $container ) {
	$paymentManager = $container->getService( "paypal-payment-manager" );
	return $paymentManager;
} );

$container->register( "prospect-appraiser", function() use ( $container ) {
	$prospectAppraiser = new \Model\Services\ProspectAppraiser(
		$container->getService( "question-choice-weight-repository" ),
		$container->getService( "respondent-repository" ),
		$container->getService( "respondent-question-answer-repository" ),
		$container->getService( "prospect-appraisal-repository" )
	);
	return $prospectAppraiser;
} );

$container->register( "questionnaire-dispatcher", function() use ( $container ) {
	$dispatcher = new \Model\Services\QuestionnaireDispatcher(
		$container->getService( "questionnaire-repository" ),
		$container->getService( "question-repository" ),
		$container->getService( "question-choice-repository" ),
		$container->getService( "question-choice-type-repository" ),
		$container->getService( "respondent-repository" ),
		$container->getService( "respondent-question-answer-repository" )
	);
	return $dispatcher;
} );

$container->register( "sequence-dispatcher", function() use ( $container ) {
	$manager = new \Model\Services\SequenceDispatcher(
		$container->getService( "sequence-repository" ),
		$container->getService( "event-dispatcher" )
	);
	return $manager;
} );

$container->register( "event-email-dispatcher", function() use ( $container ) {
	$manager = new \Model\Services\EventEmailDispatcher(
		$container->getService( "event-email-repository" ),
		$container->getService( "email-repository" ),
		$container->getService( "mailer" )
	);
	return $manager;
} );

$container->register( "event-text-message-dispatcher", function() use ( $container ) {
	$manager = new \Model\Services\EventTextMessageDispatcher(
		$container->getService( "event-text-message-repository" ),
		$container->getService( "text-message-repository" ),
		$container->getService( "sms-messager" )
	);
	return $manager;
} );

$container->register( "event-dispatcher", function() use ( $container ) {
	$manager = new \Model\Services\EventDispatcher(
		$container->getService( "event-repository" ),
		$container->getService( "event-email-dispatcher" ),
		$container->getService( "event-text-message-dispatcher" )
	);
	return $manager;
} );
