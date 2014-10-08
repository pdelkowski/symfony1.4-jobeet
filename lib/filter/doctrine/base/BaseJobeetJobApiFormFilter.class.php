<?php

/**
 * JobeetJobApi filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseJobeetJobApiFormFilter extends JobeetJobFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('jobeet_job_api_filters[%s]');
  }

  public function getModelName()
  {
    return 'JobeetJobApi';
  }
}
