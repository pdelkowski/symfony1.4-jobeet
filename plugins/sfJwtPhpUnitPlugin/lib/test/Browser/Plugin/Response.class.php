<?php
/**
 * Copyright (c) 2011 J. Walter Thompson dba JWT
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/** Extends browser response functionality.
 *
 * @author Phoenix Zerin <phoenix@todofixthis.com>
 *
 * @package sfJwtPhpUnitPlugin
 * @subpackage lib.test.browser.plugin
 *
 * Partial list of methods exposed for the encapsulated sfWebResponse object
 *  (other methods are available, but they are not read-only and are probably
 *  not useful for testing):
 *
 * @method boolean  isHeaderOnly()
 * @method string   getStatusText()
 * @method int      getStatusCode()
 * @method string   getHttpHeader(string $name, string $default = null)
 * @method boolean  hasHttpHeader(string $name)
 * @method string   getCharset()
 * @method string   getContentType()
 * @method string[] getHttpMetas()
 * @method string   getTitle()
 * @method string[] getPositions()
 * @method string[] getStylesheets(string $position = sfWebResponse::ALL)
 * @method string[] getJavascripts(string $position = sfWebResponse::ALL)
 * @method string[] getSlots()
 * @method string[] getCookies()
 * @method string[] getHttpHeaders()
 * @method string   getContent()
 * @method array    getOptions()
 */
class Test_Browser_Plugin_Response extends Test_Browser_Plugin
{
  /** Returns the name of the accessor that will invoke this plugin.
   *
   * For example, if this method returns 'getMagic', then the plugin can be
   *  invoked in a test case by calling $this->_browser->getMagic().
   *
   * @return string
   */
  public function getMethodName(  )
  {
    return 'getResponse';
  }

  /** Returns a reference to the response object from the browser context.
   *
   * @return static
   */
  public function invoke(  )
  {
    if( ! $this->hasEncapsulatedObject() )
    {
      $this->setEncapsulatedObject($this->getBrowser()->getResponse());
    }

    return $this;
  }

  /** Returns whether the response was redirected.
   *
   * @return bool
   */
  public function isRedirected(  )
  {
    return $this->hasHttpHeader('location');
  }

  /** Returns the URL that the response was redirected to.
   *
   * @return string|null
   */
  public function getRedirectUrl(  )
  {
    return $this->getHttpHeader('location');
  }
}