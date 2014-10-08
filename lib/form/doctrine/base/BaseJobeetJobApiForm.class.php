<?php

/**
 * JobeetJobApi form base class.
 *
 * @method JobeetJobApi getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseJobeetJobApiForm extends JobeetJobForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('jobeet_job_api[%s]');
  }

  public function getModelName()
  {
    return 'JobeetJobApi';
  }

}
