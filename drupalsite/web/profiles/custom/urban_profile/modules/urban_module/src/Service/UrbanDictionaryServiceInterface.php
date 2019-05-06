<?php

namespace Drupal\urban_module\Service;

/**
 * Urban Dictionary API service interface.
 */
interface UrbanDictionaryServiceInterface {

  /**
   * Get definition of urban term.
   *
   * @param string $term
   *   Urban term.
   *
   * @return \Drupal\urban_module\Model\UrbanDefinition|null
   *   Urban definition object or NULL in case of error.
   */
  public function getDefinition($term);
}
