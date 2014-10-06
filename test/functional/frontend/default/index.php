<?php
/** Functional tests for /default/index.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * @package symfony
 * @subpackage test.action
 */
class frontend_default_indexTest extends Test_Case_Functional
{
  protected
    $_application = 'frontend',
    $_url;

  protected function _setUp(  )
  {
    $this->_url = '/default/index';
  }

  public function testSmokeCheck(  )
  {
    $this->_browser->get($this->_url);
    $this->assertStatusCode(200);
  }
}