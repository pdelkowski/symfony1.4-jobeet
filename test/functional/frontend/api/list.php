<?php
/** Functional tests for /api/list.
 *
 * @author Your name here
 *
 * @package jobeet
 * @subpackage test.api
 */
class frontend_api_listTest extends Test_Case_Functional
{
  protected
    $_application = 'frontend',
    $_url;

  protected function _setUp(  )
  {
    $this->_url = '/api/list';
  }

  public function testSmokeCheck(  )
  {
    $this->_browser->get($this->_url);
    $this->assertStatusCode(200);
  }
}