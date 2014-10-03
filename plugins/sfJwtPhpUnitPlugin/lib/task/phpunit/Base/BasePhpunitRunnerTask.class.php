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

/** Base functionality for tasks to run PHPUnit tests.
 *
 * @author Phoenix Zerin <phoenix@todofixthis.com>
 *
 * @package sfJwtPhpUnitPlugin
 * @subpackage lib.task.phpunit.base
 */
abstract class BasePhpunitRunnerTask extends BasePhpunitTask
{
  protected
    $_type,
    $_paths;

  private
    $_basedir;

  public function configure(  )
  {
    parent::configure();

    $this->addOptions(array(
      new sfCommandOption(
        'filter',
        'f',
        sfCommandOption::PARAMETER_REQUIRED,
        'Regex used to filter tests; only tests matching the filter will be run.',
        null
      ),

      new sfCommandOption(
        'groups',
        'g',
        sfCommandOption::PARAMETER_REQUIRED,
        'Only run tests from the specified group(s).',
        null
      ),

      new sfCommandOption(
        'plugin',
        'p',
        sfCommandOption::PARAMETER_REQUIRED,
        'Run tests for the specified plugin.',
        null
      ),

      new sfCommandOption(
        'verbose',
        'v',
        sfCommandOption::PARAMETER_NONE,
        'If set, PHPUnit will output additional information (e.g. test names).',
        null
      ),

      new sfCommandOption(
        'stop-on-fail',
        null,
        sfCommandOption::PARAMETER_NONE,
        'If set, stop on the first failure or error.',
        null
      )
    ));
  }

  public function execute( $args = array(), $opts = array() )
  {
    $this->_runTests($this->_validatePhpUnitInput($args, $opts));
  }

  /** Return the base directory for the plugin.
   *
   * @return string(dirpath)
   */
  protected function _getBasedir(  )
  {
    if( ! isset($this->_basedir) )
    {
      /* I.e., sf_root_dir/plugins/sfJwtPhpUnitPlugin(/lib/task/phpunit/Base) */
      $this->_basedir = realpath(
        dirname(__FILE__)
        . str_repeat(DIRECTORY_SEPARATOR . '..', 4)
      );
    }

    return $this->_basedir;
  }

  /** Runs all tests of a given type.
   *
   * @param array $options PHPUnit options.
   *
   * @return void
   */
  protected function _runTests( array $options = array() )
  {
    $this->_verifyPhpUnit();

    $this->_executeGlobalBootstrap();
    $this->_executeProjectBootstrap();

    $this->_doRunTests($options);
  }

  /** Initialize the PHPUnit test runner and run tests.
   *
   * @param string[] $options
   *
   * @return void
   */
  private function _doRunTests( array $options )
  {
    if( empty($options['plugin']) )
    {
      $basedir = null;
    }
    else
    {
      try
      {
        /* @var $config sfPluginConfiguration */
        /** @noinspection PhpUndefinedMethodInspection */
        $config = $this->configuration
          ->getPluginConfiguration($options['plugin']);
      }
      catch( InvalidArgumentException $e )
      {
        throw new sfException(sprintf(
          'Plugin "%s" does not exist or is not enabled.',
            $options['plugin']
        ));
      }

      $basedir = implode(DIRECTORY_SEPARATOR, array(
        $config->getRootDir(), 'test', ''
      ));

      unset($options['plugin']);
    }

    if( $files = $this->_findTestFiles($this->_type, (array) $this->_paths, $basedir) )
    {
      /** @noinspection PhpIncludeInspection */
      require_once
        'PHPUnit' . DIRECTORY_SEPARATOR
        . 'TextUI'  . DIRECTORY_SEPARATOR
        . 'TestRunner.php';

      $Runner = new PHPUnit_TextUI_TestRunner();

      $Suite = new PHPUnit_Framework_TestSuite(ucfirst($this->name) . ' Tests');
      $Suite->addTestFiles($files);

      /* Inject the command application controller so that it is accessible to
       *  test cases.
       */
      Test_Case::setController($this->commandApplication);

      /* Ignition... */
      try
      {
        $Runner->doRun($Suite, $options);
      }
      catch( PHPUnit_Framework_Exception $e )
      {
        $this->logSection('phpunit', $e->getMessage());
      }
    }
    else
    {
      $this->logSection('phpunit', 'No tests found.');
    }
  }

  /** Generates a list of test files.
   *
   * @param string  $type ('unit', 'functional') If empty, all tests returned.
   * @param array   $paths Sub-paths within $type to search.  If empty, all
   *  tests under $type returned.
   * @param string  $basedir Base directory all $paths are relative to.
   *
   * @return string[]
   */
  protected function _findTestFiles( $type = '', array $paths = array(), $basedir = null )
  {
    if( ! $paths )
    {
      $paths = array('');
    }

    if( $type == '' )
    {
      return array_merge(
        $this->_findTestFiles('unit', $paths, $basedir),
        $this->_findTestFiles('functional', $paths, $basedir)
      );
    }
    else
    {
      if( $basedir == '' )
      {
        $basedir =
          sfConfig::get('sf_root_dir')  . DIRECTORY_SEPARATOR
          . 'test'                        . DIRECTORY_SEPARATOR;
      }
      $basedir .= $type . DIRECTORY_SEPARATOR;

      $files = array();
      foreach( $paths as $path )
      {
        $fullpath = $basedir . $path;

        /* Don't allow path injection, just in case. */
        if( array_search('..', explode(DIRECTORY_SEPARATOR, $path)) !== false )
        {
          $this->logSection(
            'phpunit',
            sprintf('Skipping unsafe path %s.', $fullpath),
            null,
            'ERROR'
          );

          continue;
        }

        /* If $fullpath points to a file, load it. */
        if( is_file($fullpath) )
        {
          $files[] = $fullpath;
        }

        /* If $fullpath points to a directory, load all files in it. */
        elseif( is_dir($fullpath) )
        {
          $files = array_merge(
            $files,
            sfFinder::type('file')
            ->name('*.php')
            ->in($fullpath)
          );
        }

        /* If $fullpath is the path to a file minus an extension, load the
         *  auto-corrected filepath.
         */
        else
        {
          $pathinfo = pathinfo($fullpath);
          $basename =
            $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'];

          $exts = array(
            '.php',
            '.class.php',
            '.test.php'
          );

          $found = false;
          foreach( $exts as $ext )
          {
            if( is_file($basename . $ext) )
            {
              $files[] = $basename . $ext;

              $found = true;
              break;
            }
          }

          if( ! $found )
          {
            $this->logSection(
              'phpunit',
              sprintf('No test files located at %s.', $fullpath)
            );
          }
        }
      }
      return $files;
    }
  }

  /** Extracts PHPUnit-specific arguments/options.
   *
   * @param array $args
   * @param array $opts
   *
   * @return array
   */
  protected function _validatePhpUnitInput( array $args, array $opts )
  {
    $allowed = array(
      'color'         => false,
      'filter'        => null,
      'groups'        => null,
      'plugin'        => null,
      'verbose'       => false,
      'stop-on-fail'  => false
    );

    $translate = array(
      'color'         => 'colors',
      'stop-on-fail'  => 'stopOnFailure'
    );

    $params = array();
    foreach( $this->_consolidateInput($args, $opts, $allowed, true) as $key => $val )
    {
      /* Coerce type. */
      if( isset($allowed[$key]) )
      {
        settype($val, gettype($allowed[$key]));
      }

      if( isset($translate[$key]) )
      {
        $key = $translate[$key];
      }

      $params[$key] = $val;
    }

    /* Special case:  groups has to be an array. */
    if( isset($params['groups']) )
    {
      $params['groups'] = preg_split('/\s*,\s*/', (string) $params['groups']);
    }

    /* Special case:  filter should not be empty. */
    if( $params['filter'] === '' )
    {
      $params['filter'] = null;
    }

    return $params;
  }

  /** Executes the global PHPUnit bootstrap file.
   *
   * @return void
   */
  protected function _executeGlobalBootstrap(  )
  {
    /* sf_root_dir/plugins/sfJwtPhpUnitPlugin/lib/test/bootstrap/phpunit.php */
    $Harness = new Test_Harness_Safe(
        $this->_getBasedir()  . DIRECTORY_SEPARATOR
      . 'lib'                 . DIRECTORY_SEPARATOR
      . 'task'                . DIRECTORY_SEPARATOR
      . 'phpunit'             . DIRECTORY_SEPARATOR
      . 'bootstrap'           . DIRECTORY_SEPARATOR
      . 'phpunit.php'
    );
    $Harness->execute();
  }

  /** Execute the project-specific bootstrap file, if it exists.
   *
   * @return void
   */
  protected function _executeProjectBootstrap(  )
  {
    /* sf_root_dir/test/bootstrap/phpunit.php */
    $init =
        sfConfig::get('sf_root_dir')  . DIRECTORY_SEPARATOR
      . 'test'                        . DIRECTORY_SEPARATOR
      . 'bootstrap'                   . DIRECTORY_SEPARATOR
      . 'phpunit.php';

    if( is_file($init) )
    {
      $Harness = new Test_Harness_Safe($init);
      $Harness->execute();
    }
  }
}
