<?php

namespace Drupal\tests\urban_module\Kernel\Stub;

use Drupal\urban_module\Model\UrbanDefinition;
use Drupal\urban_module\Service\UrbanDictionaryServiceInterface;

/**
 * Stub of urban dictionary service.
 */
class FakeUrbanDictionaryService implements UrbanDictionaryServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function getDefinition($term) {
    return new UrbanDefinition($term, "$term definition", "$term example");
  }

}
