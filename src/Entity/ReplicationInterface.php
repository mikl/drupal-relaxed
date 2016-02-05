<?php

/**
 * @file
 * Contains \Drupal\relaxed\Entity\ReplicationInterface.
 */

namespace Drupal\relaxed\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Replication entities.
 *
 * @ingroup relaxed
 */
interface ReplicationInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

}
