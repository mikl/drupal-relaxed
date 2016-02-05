<?php

/**
 * @file
 * Contains \Drupal\relaxed\Plugin\ReplicatorBase.
 */

namespace Drupal\relaxed;

use Drupal\Component\Plugin\PluginBase;
use Psr\Http\Message\UriInterface;

/**
 * Base class for Replicator plugins.
 */
abstract class ReplicatorBase extends PluginBase implements ReplicatorInterface {

  /**
   * @var
   *   The source to replicate from
   */
  protected $source;

  /**
   * @var
   *   The target to replicate too
   */
  protected $target;

  /**
   * @inheritDoc
   */
  public function setSource(UriInterface $source) {
    $this->source = $source;
  }

  /**
   * @inheritDoc
   */
  public function setTarget(UriInterface $target) {
    $this->target = $target;
  }

  /**
   * @inheritDoc
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * @inheritDoc
   */
  public function getTarget() {
    return $this->target;
  }

}
