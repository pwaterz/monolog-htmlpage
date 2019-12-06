<?php

namespace Pwaterz\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;

/**
 * Writes logs to bottom of a requested html page.
 *
 * @author Patrick Waters
 */
class HTMLPageHandler extends AbstractProcessingHandler
{

  /**
   * {@inheritdoc}
   */
  protected function write(array $record)
  {
    if (PHP_SAPI !== 'cli') {
      drupal_register_shutdown_function(function() use ($record) {
        print '<div class="monolog-htmlpagehandler"><center><div style="background-color:white; width:800px; padding: 10px; margin:10px; border: 1px solid black">';
        print '<h3>' . $record['channel'] . '</h3>';
        print '<textarea rows="10" cols="125" style="width:100%">' . htmlentities($record['formatted']) . '</textarea>';
        print '</div></center></div>';
      });
    }
  }
}
