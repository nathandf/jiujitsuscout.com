<?php
    function pritnr( $a ) {
        //fat finger error
        printr( $a );
    }
    function printr( $a, $wrap = null ) {
        if ( is_debug_ip() ) {
            echo "\n\n<hr><pre>" . print_r( $a, true ) . "</pre>\n\n";
        }
    }

    function printrd( $a, $wrap = null ) {
        if ( is_debug_ip() ) {
            echo "\n\n<hr><pre>" . print_r( $a, true ) . "</pre>\n\n";
            die();
        }
    }

    function pntr( $a ) {
      echo "<div style='z-index: 99; font-size: 12px; box-sizing: border-box; padding: 15px; border: 3px solid orange; background: #FFF; position: absolute; display: inline; left: 50; top: 50;'><p style='color: orange; font-size: 16; font-weight: 600;'>Array Debug</p><br><pre>" . print_r( $a, true ) . "</pre></div>";
    }

    function printa( $a ) {
        echo "\n\n<hr><pre>" . print_r( $a, true ) . "</pre>\n\n";
    }
    function printap( $a ) {
        echo "<hr>
        <div style='padding-left:300px;'><pre>" . print_r( $a, true ) . "</pre>
        </div>";
    }
    function printr_if( $a ) {
        if ( isset( $_SESSION[ 'debug' ] ) && ( $_SESSION[ 'debug' ] >= 1 ) ) {
            echo "\n\n<hr><pre>" . print_r( $a, true ) . "</pre>\n\n";
        }
    }
    function printar( $a ) {
        return "\n\n<hr><pre>" . print_r( $a, true ) . "</pre>\n\n";
    }
    function printrr( $n, $a ) {
        if ( isset( $_SESSION[ 'debug' ] ) && ( $_SESSION[ 'debug' ] >= 2 ) ) {
            echo "<br><br><br>\n\n<hr>\n$n\n<pre>" . print_r( $a, true ) . "</pre>\n/$n\n\n<br><br><br>";
        }
    }
    function printrra( $n, $a ) {
        echo "\n\n<hr>\n$n\n<pre>" . print_r( $a, true ) . "</pre>\n/$n\n\n";
    }
    function is_debug_ip( ) {
        if ( $_SERVER[ 'REMOTE_ADDR' ] == '::1' ) {
            //lcoal
            return true;
        } elseif ( $_SERVER[ 'REMOTE_ADDR' ] == '127.0.0.1' ) {
            //lcoal
            return true;
        } elseif ( substr( $_SERVER[ 'REMOTE_ADDR' ], 0, 8 ) == '192.168.' ) {
            //lcoal
            return true;
        }
        return false;
    }

    // nate stuff
    function vdump( $input ) {
      echo "<pre>";
      var_dump( $input );
      echo "</pre><br>";
    }

    function vdumpd( $input ) {
      echo "<pre>";
      var_dump( $input );
      echo "</pre><br>";
      die();
    }

    function echod( $input ) {
      echo $input;
      die();
    }

    class QuickTime
    {
        public static $time_start;
        public static $time_end;

        public static function start()
        {
            self::$time_start = microtime( true );
        }

        public static function end()
        {
            self::$time_end = microtime( true );
            die( "Search time took " . ( self::$time_end - self::$time_start ) . " seconds");
        }
    }

?>
