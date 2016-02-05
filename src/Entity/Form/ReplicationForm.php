<?php

/**
 * @file
 * Contains \Drupal\relaxed\Entity\Form\ReplicationForm.
 */

namespace Drupal\relaxed\Entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;

/**
 * Form controller for Replication edit forms.
 *
 * @ingroup relaxed
 */
class ReplicationForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = $entity->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Replication.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Replication.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.replication.edit_form', ['replication' => $entity->id()]);
  }

}
