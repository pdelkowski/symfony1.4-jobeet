<?php
/** Unit tests for JobeetJob.
 *
 * @author Your name here
 *
 * @package jobeet
 * @subpackage test.model
 */
class JobeetJobTest extends Test_Case_Unit
{
  protected function _setUp(  )
  {
  }

  public function testSave(  )
  {
  	
    $category = new JobeetCategory();
    $category->fromArray(array(
    	'id' => 1,
    	'name' => 'My Category',
    	'created_at' => date('Y:m:d H:i:s', time()),
    	'updated_at' => date('Y:m:d H:i:s', time())
	));
	$category->save();

    $this->assertNotNull($category);
	 
    $job = new JobeetJob();
    $job->fromArray(array(
	    'category_id'  => $category->getId(),
	    'company'      => 'Sensio Labs',
	    'position'     => 'Senior Tester',
	    'location'     => 'Paris, France',
	    'description'  => 'Testing is fun',
	    'how_to_apply' => 'Send e-Mail',
	    'email'        => 'job@example.com',
	    'token'        => rand(1111, 9999),
	    'is_activated' => true,
  	));

  	$job->save();

  	$this->assertNotNull($job);
  	$expiresAt = date('Y-m-d', time() + 86400 * sfConfig::get('app_active_days'));
	$this->assertEquals($expiresAt, $job->getDateTimeObject('expires_at')->format('Y-m-d'), '->save() updates expires_at if not set');


  }
}