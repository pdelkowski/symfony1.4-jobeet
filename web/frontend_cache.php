<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
 
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'cache', true);
sfContext::createInstance($configuration)->dispatch();