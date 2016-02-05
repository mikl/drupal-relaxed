<?php

/**
 * @file
 * Contains \Drupal\relaxed\ReplicationListBuilder.
 */

namespace Drupal\relaxed;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Replication entities.
 *
 * @ingroup relaxed
 */
class ReplicationListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Replication ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\relaxed\Entity\Replication */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $this->getLabel($entity),
      new Url(
        'entity.replication.edit_form', array(
          'replication' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
