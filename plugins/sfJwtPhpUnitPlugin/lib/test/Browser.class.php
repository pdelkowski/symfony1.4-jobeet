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

/** Adds domain-specific functionality to sfTestBrowser.
 *
 * Note:  Designed to work with Symfony 1.4.  Might not work properly with later
 *  versions of Symfony.
 *
 * @author Phoenix Zerin <phoenix@todofixthis.com>
 *
 * @package jwt
 * @subpackage lib.test
 *
 * @method sfUser           getUser()
 * @method sfBrowser        setHttpHeader(string $header, string $value)
 * @method sfBrowser        setCookie(string $name, string $value, int $expire = null, string $path = '/', string $domain = '', boolean $secure = false, boolean $httpOnly = false)
 * @method sfBrowser        removeCookie(string $name)
 * @method sfBrowser        clearCookies()
 * @method sfBrowser        setAuth(string $username, string $password)
 * @method Test_Browser     back()
 * @method Test_Browser     forward()
 * @method Test_Browser     reload()
 * @method sfDomCssSelector getResponseDomCssSelector()
 * @method DOMXPath         getResponseDomXpath()
 * @method sfDomCssSelector getResponseDom()
 * @method Exception        getCurrentException()
 * @method void             resetCurrentException()
 * @method bool             checkCurrentExceptionIsEmpty()
 * @method sfBrowser        followRedirect()
 * @method sfBrowser        setField(string $name, string $value)
 * @method sfBrowser        deselect(string $name)
 * @method sfBrowser        select(string $name)
 * @method sfBrowser        doSelect(string $name, boolean $selected)
 * @method Test_Browser     click(string $name, array $arguments = array(), array $options = array())
 * @method sfBrowser        restart()
 *
 * The following methods might or might not be available depending on which
 *  plugins are active:
 *
 * @method Test_Browser_Plugin_Content    getContent()
 * @method Test_Browser_Plugin_Error      getError()
 * @method sfForm                         getForm()
 * @method Test_Browser_Plugin_Logger     getLogger()
 * @method Test_Browser_Plugin_Mailer     getMailer()
 * @method Test_Browser_Plugin_Request    getRequest()
 * @method Test_Browser_Plugin_Response   getResponse()
 * @method mixed                          getVar()
 * @method Test_Browser_Plugin_ViewCache  getViewCache()
 */
class Test_Browser extends Test_ObjectWrapper
{
  private
    $_isCalled,
    $_plugins;

  /** Init the class instance.
   */
  public function __construct(  )
  {
    $this->_isCalled  = false;
    $this->_plugins   = array();

    $this->setEncapsulatedObject('sfBrowser');

    /* Activate commonly-used plugins. */
    $this->usePlugin(
      'content',
      'error',
      'form',
      'request',
      'response'
    );
  }

  /** Activate a plugin.
   *
   * @param string,... $plugin_name
   *
   * @return static
   */
  public function usePlugin(
    /** @noinspection PhpUnusedParameterInspection */
    $plugin_name /*, ... */
  )
  {
    foreach( func_get_args() as $name )
    {
      if( empty($this->_plugins[$name]) )
      {
        $class = Test_Browser_Plugin::sanitizeClassname($name);

        /* @var $Plugin Test_Browser_Plugin */
        $Plugin = new $class($this->getEncapsulatedObject());

        $this->_plugins[$name] = $Plugin;

        $this->injectDynamicMethod(
          $Plugin->getMethodName(),
          array($Plugin, 'invoke')
        );
      }
    }

    return $this;
  }

  /** Signs the user in as the specified user[name] or email address.
   *
   * Note:  This actually injects a listener that will log the user in before
   *  the next request because the browser clears out the context before making
   *  the request ({@see sfBrowser->doCall()}).
   *
   * @param string|sfGuardUser $user
   *
   * @throws LogicException           If sfDoctrineGuardPlugin is not enabled.
   * @throws InvalidArgumentException If $user cannot be resolved to an
   *  sfGuardUser.
   * @return static
   */
  public function signin( $user )
  {
    /* This functionality relies on sfDoctrineGuardPlugin. */
    $plugins = sfContext::getInstance()->getConfiguration()->getPlugins();
    if( ! in_array('sfDoctrineGuardPlugin', $plugins) )
    {
      throw new LogicException(sprintf(
        'Cannot invoke %s->%s(); sfDoctrineGuardPlugin is not enabled.',
          __CLASS__,
          __FUNCTION__
      ));
    }

    if( is_string($user) )
    {
      $name = $user;
      $user = sfGuardUserTable::getInstance()
        ->retrieveByUsernameOrEmailAddress($name);

      if( ! $user )
      {
        throw new InvalidArgumentException(sprintf(
          'No such user "%s".',
            $name
        ));
      }
    }

    if( ! $user instanceof sfGuardUser )
    {
      throw new InvalidArgumentException(sprintf(
        'Invalid %s encountered; sfGuardUser or string expected.',
          (is_object($user) ? get_class($user) : gettype($user))
      ));
    }

    $this->addListener(new Test_Browser_Listener_Signin($user));
    return $this;
  }

  /** Gets a URI.
   *
   * @param string $uri         The URI to fetch
   * @param array  $parameters  The Request parameters
   * @param bool   $changeStack  Change the browser history stack?
   *
   * @return static
   */
  public function get( $uri, $parameters = array(), $changeStack = true )
  {
    return $this->call($uri, 'get', $parameters, $changeStack);
  }

  /** Posts a URI.
   *
   * @param string $uri         The URI to fetch
   * @param array  $parameters  The Request parameters
   * @param bool   $changeStack  Change the browser history stack?
   *
   * @return static
   */
  public function post( $uri, $parameters = array(), $changeStack = true )
  {
    return $this->call($uri, 'post', $parameters, $changeStack);
  }

  /** Execute a browser request.
   *
   * @param string $uri          The URI to fetch
   * @param string $method       The request method
   * @param array  $parameters   The Request parameters
   * @param bool   $changeStack  Change the browser history stack?
   *
   * @return static
   */
  public function call( $uri, $method = 'get', $parameters = array(), $changeStack = true )
  {
    $uri = $this->genUrl($uri);

    /* @var $Plugin Test_Browser_Plugin */
    foreach( $this->_plugins as $Plugin )
    {
      $Plugin->initialize();
    }

    /** @noinspection PhpUndefinedMethodInspection */
    $this->getEncapsulatedObject()->call(
      $uri,
      $method,
      $this->_stringifyParameters($parameters),
      $changeStack
    );
    $this->_isCalled = true;

    return $this;
  }

  /** Converts routing info into a functional-test-compatible URI for the
   *    current application.
   *
   * @param mixed $uri      URI, route name or parameters.
   * @param bool  $absolute Whether to generate an absolute URL.
   *
   * @return string
   */
  public function genUrl( $uri, $absolute = false )
  {
    /** Ensure the browser context is available.
     *
     * @see sfBrowser::getContext()
     */
    $context = $this->getContext();

    /** @kludge Routing uses a prefix of './symfony' by default when in CLI
     *    mode, and there is no easy way to override this.
     *
     * A simple setOption() method would be nice, but neither sfRouting nor
     *  sfPatternRouting has that, so we have to settle for mocking an event
     *  notification to fool the routing into thinking that it is re-parsing the
     *  request parameters.
     *
     * @see sfRouting::fixGeneratedUrl()
     * @see http://trac.symfony-project.org/ticket/3889
     */
    $options = $context->getRouting()->getOptions();
    if( $options['context']['prefix'] != '' )
    {
      /** @var $request sfWebRequest */
      $request = $context->getRequest();
      $request->setRelativeUrlRoot('');

      /** @see sfWebRequest::parseRequestParameters() */
      $context->getEventDispatcher()->filter(
        new sfEvent(
          $request,
          'request.filter_parameters',
          $request->getRequestContext()
        ),
        array()
      );
    }

    /** @noinspection PhpUndefinedMethodInspection */
    return $context->getController()->genUrl($uri, $absolute);
  }

  /** Returns whether the browser has made a request yet.
   *
   * @return bool
   */
  public function isCalled(  )
  {
    return $this->_isCalled;
  }

  /** Adds an event listener to the browser object.
   *
   * @param Test_Browser_Listener $listener
   *
   * @return static
   */
  public function addListener( Test_Browser_Listener $listener )
  {
    foreach( $listener->getEventNames() as $event )
    {
      /** @noinspection PhpUndefinedMethodInspection */
      $this->getEncapsulatedObject()->addListener(
        $event,
        array($listener, 'invoke')
      );
    }

    return $this;
  }

  /** Returns the current application context.
   *
   * @param bool $forceReload Whether to ignore existing context instance.
   *
   * @return sfContext
   */
  public function getContext( $forceReload = false )
  {
    /** @noinspection PhpUndefinedMethodInspection */
    $context = $this->getEncapsulatedObject()->getContext($forceReload);

    /** If an error occurs while initializing the context object, it will try
     *    to dump a stack trace.
     *
     * @see sfContext::initialize()
     */
    if( $e = $this->getCurrentException() )
    {
      ob_end_clean();
      throw $e;
    }

    return $context;
  }

  /** Handles an attempt to call a non-existent method.
   *
   * @param string $meth
   *
   * @return void
   * @throws BadMethodCallException
   */
  protected function handleBadMethodCall( $meth )
  {
    throw new BadMethodCallException(sprintf(
      'Call to undefined method %s->%s() - did you forget to call usePlugin()?',
        __CLASS__,
        $meth
    ));
  }

  /** Converts parameters to strings before sending the request.
   *
   * @param array $params
   *
   * @return array(string|array)
   */
  protected function _stringifyParameters( array $params )
  {
    $stringified = array();

    foreach( $params as $key => $val )
    {
      $stringified[$key] = (
        (is_scalar($val) or (is_object($val) and method_exists($val, '__toString')))
          ? (string) $val
          : $this->_stringifyParameters((array) $val)
      );
    }

    return $stringified;
  }
}