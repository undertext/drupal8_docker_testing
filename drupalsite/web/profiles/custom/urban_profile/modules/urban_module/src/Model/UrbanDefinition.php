<?php

namespace Drupal\urban_module\Model;

/**
 * Urban definition value object.
 */
class UrbanDefinition {

  /**
   * Term name.
   *
   * @var string
   */
  private $term;

  /**
   * Term definition.
   *
   * @var string
   */
  private $definition;

  /**
   * Example of using a term in a sentence.
   *
   * @var string
   */
  private $example;

  /**
   * UrbanDefinition constructor.
   *
   * @param $term
   * @param $definition
   * @param $example
   */
  public function __construct($term, $definition, $example) {
    $this->term = $term;
    $this->definition = $definition;
    $this->example = $example;
  }

  /**
   * Get term name.
   *
   * @return string
   */
  public function getTerm() {
    return $this->term;
  }

  /**
   * Get term definition.
   *
   * @return string
   *   Term definition.
   */
  public function getDefinition() {
    return $this->definition;
  }

  /**
   * Get example of term usage in a sentence.
   *
   * @return string
   *   Example of term usage in a sentence.
   */
  public function getExample() {
    return $this->example;
  }

}
