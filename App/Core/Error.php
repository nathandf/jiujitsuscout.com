<?php
/*
* Error Handling Class
*/
namespace Core;

class Error
{
  private static $environment;

  public static function setEnv( $environment )
  {
    self::$environment = $environment;
  }

  // Convert all error to Exceptions by throwing and ErrorException
  public static function errorHandler( $level, $message, $file, $line )
  {
    if ( error_reporting() !== 0 ) { // to keep the @ operator working
      throw new \ErrorException( $message, 0, $level, $file, $line );
    }
  }

  public static function exceptionHandler( $exception )
  {
    // Code is 404 or 500 (general error)
    $code = $exception->getCode();
    if ( $code != 404 ) {
      $code = 500;
    }
    http_response_code( $code );

    if ( self::$environment == "development" ) {
      // some debug functions
      require_once( "App/Helpers/debug.php" );

      echo "<h1>Fatal error</h1>";
      echo "<p>Uncaught exception: '" . get_class( $exception ) . "'</p>";
      echo "<p>Message: '" . $exception->getMessage() . "'</p>";
      echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
      echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
    } else {
      $log = "logs/errors/" . date( "Y-m-d" ) . ".txt";
      ini_set( 'error_log', $log );
      $message = "Uncaught exception: '" . get_class( $exception ) . "'";
      $message .= " with message '" . $exception->getMessage() . "'";
      $message .= "\nStack trace: " . $exception->getTraceAsString();
      $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

      error_log( $message );

      require_once( "App/Views/$code.shtml" );
    }
  }
}
