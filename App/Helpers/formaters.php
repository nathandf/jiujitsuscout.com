<?php
    function phone_human( $s ) {
        if ( strlen( $s ) == 10 ) {
            // (713) 123-4567
            return preg_replace( "/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $s );
        } elseif ( strlen( $s ) == 11 ) {
            // +1 (713) 123-4567
            return preg_replace( "/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "+$1($2) $3-$4", $s );
        } elseif ( strlen( $s ) > 4 ) {
            //pffttt no idea just add a - every 3 letters
            return implode( "-", str_split( substr( $s, 0, -4 ), 3 ) ) . '-' . substr( $s, -4 );
        } else {
            return $s;
            return preg_replace( "/[^0-9]/", "", $s );
        }
    }
    if ( !isset( $template_dir ) ) {
        $template_dir = __DIR__ . "/../templates/";
    }
    function load_template( $ff, $bk = false ) {
        //file name as string
        global $template_dir;
        if ( ( $bk === 1 ) || ( $bk === true ) ) {
            //load one lower
            $fzz = realpath( "../" . $template_dir . $ff );
            if ( $fzz == '' ) {
                die( 'Failed to find ' . "../" . $template_dir . $ff . " AKA '" . $fzz . "'" );
            }
        } else if ( $bk == 'full' ) {
            //pass FULL path
            $fzz = realpath( $ff );
            if ( $fzz == '' ) {
                die( 'Failed to find ' . $ff . " AKA " . $fzz );
            }
        } else {
            $fzz = realpath( $template_dir . $ff );
            if ( $fzz == '' ) {
                die( 'Failed to find ' . $template_dir . $ff );
            }
        }
        $r = file_get_contents( $fzz );
        if ( $r === false ) {
            die( 'Error with ' . $template_dir . $ff . ' :: ' . realpath( $template_dir ) . ' :: ' . $fzz );
        }
        if ( isset( $_SESSION[ 'debug' ] ) && ( $_SESSION[ 'debug' ] >= 2 ) ) {
            $r = "\n<!--==START " . $fzz . "==-->\n" . $r . "\n<!--==END " . $fzz . "==-->\n";
        }
        return $r;
    }
    function clean_tempalte( $s ) {
        //html string
        global $_js_ver;
        if ( !isset( $_js_ver ) ) {
            $_js_ver = '?r=' . sha1( microtime( true ) );
        }
        $before             = strlen( $s );
        $ars                = array( );
        $ars[ '      ' ]    = ' ';
        $ars[ '        ' ]  = ' ';
        $ars[ "\n\n" ]      = "\n";
        //
        //make them unreadable
        //
        //   $ars[ "\n" ]       = '';
        ##
        $ars[ "\t" ]        = '';
        $ars[ '  ' ]        = ' ';
        $ars[ '; ' ]        = ';';
        $ars[ '" >' ]       = '">';
        $ars[ ' </' ]       = '</';
        $ars[ "' >" ]       = "'>";
        $ars[ "  <" ]       = " <";
        $ars[ "\n<td" ]     = "<td";
        $ars[ "\n " ]       = "\n";
        $ars[ "\n</tr" ]    = "</tr";
        $ars[ "\n<option" ] = "<option";
        $ars[ '.js">' ]     = '.js' . $_js_ver . '">';
        $ars[ '.css">' ]    = '.css' . $_js_ver . '">';
        $ars[ '.css"/>' ]   = '.css' . $_js_ver . '"/>';
        $ars[ '.css" ' ]    = '.css' . $_js_ver . '" ';
        $ars[ "//FK//" ]    = "";
        foreach ( $ars as $f => $t ) {
            $n = 1;
            while ( $n ) {
                $s = str_replace( $f, $t, $s, $n );
            }
        }
        if ( isset( $_SESSION[ 'debug' ] ) && ( $_SESSION[ 'debug' ] == 1 ) && ( !isset( $_GET[ 'aspdf' ] ) ) ) {
            $s     = str_replace( "<!--", "\n<!--", $s );
            $s     = str_replace( "-->", "-->\n", $s );
            $after = strlen( $s );
            $s .= "<!-- Saved " . ( $before - $after ) . " -->";
        }
        return $s;
    }
    function smart_template( $s, $ar, $looped = false ) {
        //html string, array
        $st = microtime( true );
        global $_HOST_;
        global $_IMG_;
        global $_js_ver;
        global $_TITLE_;
        global $_SITE_;
        $ar[ '_HOST_' ]  = $_HOST_;
        $ar[ '_IMG_' ]   = $_IMG_;
        $ar[ 'js_ver' ]  = $_js_ver;
        $ar[ '_TITLE_' ] = $_TITLE_;
        $ar[ '_SITE_' ]  = $_SITE_;
        if ( isset( $ar[ 'js_vars' ] ) && is_array( $ar[ 'js_vars' ] ) ) {
            $js_vars = array( );
            foreach ( $ar[ 'js_vars' ] as $kk => $vv ) {
                $js_vars[ ] = "var " . $kk . ' = ' . json_encode( $vv ) . ';';
            }
            $ar[ 'js_vars' ] = implode( "\n", $js_vars );
        }
        foreach ( $ar as $kk => $vv ) {
            //            echo "\n<br>:".$kk.":".$vv;
            if ( is_array( $vv ) ) {
                $vv = multi_implode( '', $vv );
            }
            $s = str_replace( "{" . $kk . "}", $vv, $s );
        }
        if ( $looped !== -5 ) {
            $s = clean_tempalte( $s );
        }
        $n = 1;
        while ( $n ) {
            $s = str_replace( " </", '</', $s, $n );
        }
        if ( $looped === false ) {
            if ( strstr( $s, '{' ) !== false ) {
                $s = smart_template( $s, $ar, true );
            }
        }
        $sk = md5( $s );
        if ( isset( $_SESSION[ 'debug' ] ) && ( $_SESSION[ 'debug' ] >= 2 ) ) {
            return "\n<!-- START $sk -->\n" . $s . "\n<!-- END $sk t:" . number_format( ( microtime( true ) - $st ), 7 ) . "-->\n";
        } else {
            return $s;
        }
    }
    function multi_implode( $glue, $array ) {
        $out = "";
        foreach ( $array as $item ) {
            if ( is_array( $item ) ) {
                if ( empty( $out ) ) {
                    $out = multi_implode( $glue, $item );
                } else {
                    $out .= $glue . multi_implode( $glue, $item );
                }
            } else {
                if ( empty( $out ) )
                    $out = $item;
                else
                    $out .= $glue . $item;
            }
        }
        return $out;
    }
    function is_selected( $a, $b ) {
        if ( $a == $b ) {
            return " selected ";
        }
    }
    function is_selectedv( $a, $b ) {
        $o = ' value="' . $a . '" ';
        if ( $a == $b ) {
            $o .= " selected ";
        }
        return $o;
    }
    function simple_select_label( $label, $pid, $picked = 0, $onc = null ) {
        $ar        = array( );
        $ar[ '0' ] = "No";
        $ar[ '1' ] = "Yes";
        return '
<div class="row collapse">
	<div class="medium-6 columns">
	<label>' . $label . '</label>' . simple_select( $ar, $pid, $picked, $onc ) . '
	</div>
</div>';
    }
    function simple_select( $ar, $pid, $picked = null, $onc = null, $oncx = null ) {
        $out = array( );
        if ( $onc == null ) {
            $onct = '';
        } else {
            $onct = ' onchange="' . $onc . '()" ';
        }
        if ( $oncx != null ) {
            $onct = ' onchange="' . $oncx . '" ';
        }
        $out[ ] = '<select id="' . $pid . '" name="' . $pid . '"' . $onct . '>';
        foreach ( $ar as $kk => $vv ) {
            $out[ ] = '<option ' . is_selv( $kk, $picked ) . '>' . d_o( $vv ) . '</option>';
        }
        $out[ ] = '</select>';
        return implode( "\n", $out );
    }
    function is_selv( $a, $b ) {
        $o = ' value="' . $a . '" ';
        if ( $a == $b ) {
            $o .= " selected ";
        }
        return $o;
    }
       function sflush( ) {
        @flush();
        @ob_flush();
    }
?>