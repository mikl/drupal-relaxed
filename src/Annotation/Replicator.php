<?php

/**
 * @file
 * Contains \Drupal\relaxed\Annotation\Replicator.
 */

namespace Drupal\relaxed\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Replicator item annotation object.
 *
 * @see \Drupal\relaxed\Plugin\ReplicatorManager
 * @see plugin_api
 *
 * @Annotation
 */
class Replicator extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
