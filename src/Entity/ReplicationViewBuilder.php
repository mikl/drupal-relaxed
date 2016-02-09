<?php

namespace Drupal\relaxed\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

class ReplicationViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'FULL', $langcode = NULL) {
    $build = parent::view($entity, $view_mode, $langcode);
    $form = \Drupal::getContainer()->get('form_builder')->getForm('\Drupal\relaxed\Form\ReplicationActionForm', $entity);

    $build['form'] = $form;

    return $build;
  }

}
