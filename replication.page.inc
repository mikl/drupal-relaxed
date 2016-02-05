<?php

/**
 * @file
 * Contains replication.page.inc..
 *
 * Page callback for Replication entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Replication templates.
 *
 * Default template: replication.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_replication(array &$variables) {
  // Fetch Replication Entity Object.
  $replication = $variables['elements']['#replication'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
