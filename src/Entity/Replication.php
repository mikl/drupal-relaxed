<?php

/**
 * @file
 * Contains \Drupal\relaxed\Entity\Replication.
 */

namespace Drupal\relaxed\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Replication entity.
 *
 * @ingroup relaxed
 *
 * @ContentEntityType(
 *   id = "replication",
 *   label = @Translation("Replication"),
 *   handlers = {
 *     "access" = "Drupal\relaxed\Entity\ReplicationAccessControlHandler",
 *     "view_builder" = "Drupal\relaxed\Entity\ReplicationViewBuilder",
 *     "list_builder" = "Drupal\relaxed\ReplicationListBuilder",
 *     "views_data" = "Drupal\relaxed\Entity\ReplicationViewsData",
 *     "form" = {
 *       "default" = "Drupal\relaxed\Entity\Form\ReplicationForm",
 *       "add" = "Drupal\relaxed\Entity\Form\ReplicationForm",
 *       "edit" = "Drupal\relaxed\Entity\Form\ReplicationForm",
 *       "delete" = "Drupal\relaxed\Entity\Form\ReplicationDeleteForm",
 *     },
 *   },
 *   base_table = "replication",
 *   admin_permission = "administer Replication entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/replication/{replication}",
 *     "edit-form" = "/admin/replication/{replication}/edit",
 *     "delete-form" = "/admin/replication/{replication}/delete"
 *   },
 *   field_ui_base_route = "replication.settings",
 *   local = TRUE
 * )
 */
class Replication extends ContentEntityBase implements ReplicationInterface {
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Replication entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Replication entity.'))
      ->setReadOnly(TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Created by'))
      ->setDescription(t('The user ID of person who started the deployment.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\relaxed\Entity\Replication::getCurrentUserId');

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title for the deployment.'))
      ->setRequired(TRUE)
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'))
      ->setDescription(t('The description for the deployment.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textarea',
        'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['source'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Source'))
      ->setDescription(t('The source endpoint.'))
      ->setRequired(TRUE)
      ->setSetting('target_type', 'endpoint')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => -2,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -2,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['target'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Target'))
      ->setDescription(t('The target endpoint.'))
      ->setRequired(TRUE)
      ->setSetting('target_type', 'endpoint')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => -1,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -1,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $replicators = self::getReplicatorAllowedValues();
    $fields['replicator'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Replicator'))
      ->setDescription(t('The replicator plugin.'))
      ->setRequired(TRUE)
      ->setSettings(array(
        'allowed_values' => $replicators
      ))
      ->setDefaultValue(reset($replicators))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['replicated'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Deployed'))
      ->setDescription(t('The time that the entity was deployed.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  /**
   * Default value callback for 'uid' base field definition.
   *
   * @see ::baseFieldDefinitions()
   *
   * @return array
   *   An array of default values.
   */
  public static function getCurrentUserId() {
    return array(\Drupal::currentUser()->id());
  }

  protected static function getReplicatorAllowedValues() {
    $replicators = \Drupal::service('plugin.manager.replicator')->getDefinitions();
    $replicator_allowed_values = [];
    foreach($replicators as $replicator) {
      $replicator_allowed_values[$replicator['id']] = $replicator['label'];
    }
    return $replicator_allowed_values;
  }

}
