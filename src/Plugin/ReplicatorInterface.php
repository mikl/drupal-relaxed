<?php

/**
 * @file
 * Contains \Drupal\relaxed\Plugin\ReplicatorInterface.
 */

namespace Drupal\relaxed;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Psr\Http\Message\UriInterface;

/**
 * Defines an interface for Replicator plugins.
 */
interface ReplicatorInterface extends PluginInspectionInterface {

  /**
   * Parses the URI for use by the push method.
   *
   * @param \Psr\Http\Message\UriInterface $source
   */
  public function setSource(UriInterface $source);

  /**
   * Parses the URI to use by the push method
   *
   * @param \Psr\Http\Message\UriInterface $target
   */
  public function setTarget(UriInterface $target);

  /**
   * @return mixed
   */
  public function getSource();

  /**
   * @return mixed
   */
  public function getTarget();

  /**
   * @return array
   */
  public function push();

}
