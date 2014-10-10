<?php

/**
 * cityinfo actions.
 *
 * @package    jobeet
 * @subpackage cityinfo
 * @author     Piotr Delkowski
 * @version    1.0
 */
class cityinfoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $key = 'ab116cc5-1b96-44b2-a161-6734c50960fd';
    $city = 'Los Angeles';
    $state = 'California';
    $method = 'DeFactoSF1Part1ByNameState';

    $this->results = '';

   	try {
	    $this->results = SoapApi::request($method, array(
	    	'place'	=> $city,
	    	'state' => $state,
	    	'key' => $key
	    ));
    } catch ( Exception $e ) {
    	echo '<pre>';
    	print_r($e);
    	die;
    }
  }
}
