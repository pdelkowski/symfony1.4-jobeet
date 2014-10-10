<?php

class SoapApiaa
{
    public static $response = array();

    public static function Call( $strMethod, $arrArguments = array() )
    {
        $strWsdlUrl = self::GetUrlForWsdl();


        $objSoapClient = new nusoap_client( $strWsdlUrl, true, false, false, false, false, 5, 120 );

        $objSoapClient->soap_defencoding = 'UTF-8';
        $objSoapClient->decode_utf8 = false;

        self::$response = $objSoapClient->call( $strMethod, $arrArguments, '' );

        $mixError = $objSoapClient->getError();
        if ( is_string( $mixError ) ) {
            throw new Exception( "$strWsdlUrl, $arrArguments, $mixError" );
        }
        return self::$response;
    }

    public static function GetUrlForWsdl()
    {
        return sfConfig::get('app_wsdl_url');
    }
}