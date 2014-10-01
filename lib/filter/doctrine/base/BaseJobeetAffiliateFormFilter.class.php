<?php

/**
 * JobeetAffiliate filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Piotr Delkowski
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseJobeetAffiliateFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'token'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'jobeet_categories_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'JobeetCategory')),
    ));

    $this->setValidators(array(
      'url'                    => new sfValidatorPass(array('required' => false)),
      'email'                  => new sfValidatorPass(array('required' => false)),
      'token'                  => new sfValidatorPass(array('required' => false)),
      'is_active'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'jobeet_categories_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'JobeetCategory', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('jobeet_affiliate_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Call Stack:
    0.0000     232304   1. {main}() C:\wamp\www\learnsymfony.dev\symfony:0
    0.0030     519400   2. include('C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\command\cli.php') C:\wamp\www\learnsymfony.dev\symfony:14
    0.3090    6297008   3. sfSymfonyCommandApplication->run() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\command\cli.php:20
    0.3180    6303344   4. sfTask->runFromCLI() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\command\sfSymfonyCommandApplication.class.php:76
    0.3190    6305560   5. sfBaseTask->doRun() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfTask.class.php:97
    0.3420    6895424   6. sfDoctrineBuildTask->execute() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfBaseTask.class.php:68
    2.5420   12901072   7. sfTask->run() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\task\sfDoctrineBuildTask.class.php:182
    2.5420   12905000   8. sfBaseTask->doRun() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfTask.class.php:173
    2.5510   12906984   9. sfDoctrineBuildFiltersTask->execute() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfBaseTask.class.php:68
    2.5530   12912384  10. sfGeneratorManager->generate() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\task\sfDoctrineBuildFiltersTask.class.php:64
    2.5570   13009736  11. sfDoctrineFormFilterGenerator->generate() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\generator\sfGeneratorManager.class.php:113
    2.5850   13015720  12. sfGenerator->evalTemplate() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\generator\sfDoctrineFormFilterGenerator.class.php:92
    2.5870   13072616  13. require('C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\data\generator\sfDoctrineFormFilter\default\template\sfDoctrineFormFilterGeneratedTemplate.php') C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\generator\sfGenerator.class.php:84
    2.6040   13074456  14. sfInflector::camelize() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\data\generator\sfDoctrineFormFilter\default\template\sfDoctrineFormFilterGeneratedTemplate.php:45
    2.6040   13075032  15. sfToolkit::pregtr() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\util\sfInflector.class.php:32
    2.6040   13075976  16. preg_replace() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\util\sfToolkit.class.php:362


Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Call Stack:
    0.0000     232304   1. {main}() C:\wamp\www\learnsymfony.dev\symfony:0
    0.0030     519400   2. include('C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\command\cli.php') C:\wamp\www\learnsymfony.dev\symfony:14
    0.3090    6297008   3. sfSymfonyCommandApplication->run() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\command\cli.php:20
    0.3180    6303344   4. sfTask->runFromCLI() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\command\sfSymfonyCommandApplication.class.php:76
    0.3190    6305560   5. sfBaseTask->doRun() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfTask.class.php:97
    0.3420    6895424   6. sfDoctrineBuildTask->execute() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfBaseTask.class.php:68
    2.5420   12901072   7. sfTask->run() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\task\sfDoctrineBuildTask.class.php:182
    2.5420   12905000   8. sfBaseTask->doRun() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfTask.class.php:173
    2.5510   12906984   9. sfDoctrineBuildFiltersTask->execute() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\task\sfBaseTask.class.php:68
    2.5530   12912384  10. sfGeneratorManager->generate() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\task\sfDoctrineBuildFiltersTask.class.php:64
    2.5570   13009736  11. sfDoctrineFormFilterGenerator->generate() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\generator\sfGeneratorManager.class.php:113
    2.5850   13015720  12. sfGenerator->evalTemplate() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\generator\sfDoctrineFormFilterGenerator.class.php:92
    2.5870   13072616  13. require('C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\data\generator\sfDoctrineFormFilter\default\template\sfDoctrineFormFilterGeneratedTemplate.php') C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\generator\sfGenerator.class.php:84
    2.6040   13074456  14. sfInflector::camelize() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\data\generator\sfDoctrineFormFilter\default\template\sfDoctrineFormFilterGeneratedTemplate.php:45
    2.6040   13075032  15. sfToolkit::pregtr() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\util\sfInflector.class.php:32
    2.6040   13075976  16. preg_replace() C:\wamp\www\learnsymfony.dev\lib\vendor\symfony\lib\util\sfToolkit.class.php:362

JobeetCategoriesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.JobeetCategoryAffiliate JobeetCategoryAffiliate')
      ->andWhereIn('JobeetCategoryAffiliate.category_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'JobeetAffiliate';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'url'                    => 'Text',
      'email'                  => 'Text',
      'token'                  => 'Text',
      'is_active'              => 'Boolean',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'jobeet_categories_list' => 'ManyKey',
    );
  }
}
