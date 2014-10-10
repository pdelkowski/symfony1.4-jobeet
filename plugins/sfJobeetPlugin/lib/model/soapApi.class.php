<?php

class sfJobeetSoapApi
{
    public static $response = array();

    public static function request( $strWsdlUrl, $strMethod, $params = array() )
    {
        $objSoapClient = new nusoap_client( $strWsdlUrl, true, false, false, false, false, 5, 120 );

        $objSoapClient->soap_defencoding = 'UTF-8';
        $objSoapClient->decode_utf8 = false;

        self::$response = $objSoapClient->call( $strMethod, $params, '' );

        $errors = $objSoapClient->getError();
        if ( is_string( $errors ) ) {
            throw new Exception( "$strWsdlUrl, $params, $errors" );
        }
        return self::$response;
    }
    
}