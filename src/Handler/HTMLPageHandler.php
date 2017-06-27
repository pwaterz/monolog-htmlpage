<?php

namespace Pwaterz\Monolog\Handler;

use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Writes logs to bottom of a requested html page.
 *
 * @author Patrick Waters
 */
class HTMLPageHandler extends AbstractProcessingHandler
{

  /**
   * @param int     $level          The minimum logging level at which this handler will be triggered
   * @param Boolean $bubble         Whether the messages that are handled can bubble up the stack or not
   */
  public function __construct($level = Logger::DEBUG, $bubble = true)
  {
    parent::__construct($level, $bubble);
  }

  /**
   * {@inheritDoc}
   */
  protected function getDefaultFormatter(): FormatterInterface
  {
    return new LineFormatter('[%datetime%] %channel%.%level_name%: %message% %context% %extra%');
  }

  /**
   * {@inheritdoc}
   */
  protected function write(array $record)
  {
    drupal_register_shutdown_function(function() use ($record) {
      print '<center><div style="background-color:white; width:800px; padding: 10px; margin:10px; border: 1px solid black">';
      print '<h3>Log Level: ' . $this->messageType . '</h3>';
      print '<textarea rows="10">' . htmlentities($record['formatted']) . '</textarea>';
      print '</div></center>';
    });
  }
}
