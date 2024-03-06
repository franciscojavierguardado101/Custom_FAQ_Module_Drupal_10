<?php

namespace Drupal\my_faq\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\taxonomy\Entity\Term;

/**
 * Defines the FAQ entity.
 *
 * @ingroup faq
 */
class Faq extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityInterface $entity, $clone) {
    parent::preCreate($entity, $clone);
    $entity->setNewRevision();
  }

  /**
   * {@inheritdoc}
   */
  public function getBaseFieldDefinitions() {
    $fields = parent::getBaseFieldDefinitions();

    $fields['question'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Question'))
      ->setRequired(TRUE);

    $fields['answer'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Answer'))
      ->setRequired(TRUE);

    $fields['field_category'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Category'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler', 'default:taxonomy_term')
      ->setCardinality(1);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * {@inheritdoc}
   */
  public static function entityTypeLabel() {
    return t('FAQ');
  }

  /**
   * Returns the FAQ category as a string.
   *
   * @return string|null
   *   The FAQ category name or NULL if not set.
   */
  public function getFaqCategory() {
    $category = $this->get('field_category')->entity;
    return $category instanceof Term ? $category->getName() : NULL;
  }
}
