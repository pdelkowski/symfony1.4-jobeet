<?php

/**
 * category actions.
 *
 * @package    jobeet
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  		$this->categories = Doctrine_Core::getTable('JobeetCategory')->getWithJobs();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->category = Doctrine_Core::getTable('JobeetCategory')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->category);
  }

  public function executeShowJobs(sfWebRequest $request)
  {
    
  }
}
