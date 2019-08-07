<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View extends CoreObject
{

    private $templatingEngine;
    public $container;
    public $template;
    public $data = [];

    /**
     * View constructor.
     * @param DI_Container $container
     */
    public function __construct( DI_Container $container )
    {
        $this->setContainer( $container );
    }

    /**
     * @param string $redirect_url
     * @param int $http_response_code
     * @param bool $external_redirect
     */
    public function redirect( $redirect_url, $http_response_code = 200, $external_redirect = false )
    {
        if ( $external_redirect ) {
            header( "Location: " . $redirect_url );
            exit();
        }
        http_response_code( $http_response_code );
        header( "Location: " . HOME . $redirect_url );
        exit();
    }

    public function externalRedirect( $redirect_url )
    {
        header( "Location: " . $redirect_url );
        exit();
    }

    /**
     *
     */
    protected function setTemplatingEngine()
    {
        $this->templatingEngine = $this->load( "templating-engine" );

        // All templates are pulled from here
        $this->templatingEngine->template_dir = "App/templates";
        $this->templatingEngine->compile_dir = "App/templates/tmp";
        // Constants
        $this->templatingEngine->assign( "HOME", HOME );
        $this->templatingEngine->assign( "JS_SCRIPTS", "public/js/" );
        $this->templatingEngine->assign( "PHP_SCRIPTS", "App/scripts/php/" );

    }

    /**
     * NOTE: This should only be set after all inputs have been analyzed and validated
     * @param array $error_messages
     */
    public function setErrorMessages( array $error_messages )
    {
        $this->assign( "error_messages", $error_messages );
    }

    public function setFlashMessages( array $flash_messages )
    {
        $this->assign( "flash_messages", $flash_messages );
    }

    /**
     * @param string $file_name
     * @param null $data
     */
    public function render( $file_name, $data = null )
    {
        $this->setTemplatingEngine();

        // assigning data from the views to the templating engine
        foreach ( $this->data as $key => $value ) {
            $this->templatingEngine->assign( $key, $value );
        }

        // render view
        ob_start();
        require_once( $file_name );
        ob_end_flush();

    }

    /**
     * @param string $template
     */
    public function setTemplate( $template )
    {
        $this->template = $template;
    }

    /**
     * @param string $index
     * @param mixed $data
     * @param bool $sanitize
     */
    public function assign( $index, $data, $sanitize = true )
    {
        $this->data[ $index ] = $data;
    }

    public function render404()
    {
        $this->render( "App/templates/404.shtml" );
        exit();
    }

    public function render403()
    {
        $this->render( "App/templates/403.shtml" );
        exit();
    }

}
