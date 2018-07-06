<?php
/**
 * Core Controller Class
 */
namespace Core;

abstract class Controller extends CoreObject
{
    protected $session;
    protected $container;
    protected $params;
    protected $view;
    protected $action_filter_data = [];

    public function __construct( DI_Container $container, Session $session, $params )
    {
        $this->setContainer( $container );
        $this->session = $session;
        $this->params = $params;
        $this->view = $this->load( "view" );
    }

    public function __call( $name, $args )
    {
        $method = $name . "Action";
        if ( method_exists( $this, $method ) ) {
            if ( $this->before() !== false ) {
                call_user_func_array( [ $this, $method ], $args );
                $this->after();
            }
        } else {
            throw new \Exception( "Method \"$method\" is not a method of class " . get_class( $this ), 404 );
        }
    }

    // Remove "Action" from the end of the method names on which you don't want the
    // before or action methods to be invoked automatically
    protected function before()
    {}

    protected function after()
    {}

    protected function requireParam( $param )
    {
        if ( !isset( $this->params[ $param ] ) ) {
            $this->view->render404();
            exit();
        }
    }

    protected function issetParam( $param )
    {
        if ( !isset( $this->params[ $param ] ) ) {
            return false;
        }
        return true;
    }
}
