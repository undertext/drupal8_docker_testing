<?php

namespace Drupal\tests\urban_module\Kernel;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\node\NodeTypeInterface;

/**
 * Tests hooks of urban_module module.
 */
class UrbanDefinitionPresaveKernelTest extends KernelTestBase {

  protected static $modules = [
    'node',
    'system',
    'field',
    'user',
    'urban_module',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->classLoader->addPsr4("Drupal\\tests\\urban_module\\Kernel\\Stub\\", __DIR__ . '/../Kernel/Stub');
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');

    $content_type = NodeType::create([
      'type' => 'urban_definition',
      'name' => 'Urban definition',
    ]);
    $content_type->save();
    $this->addTextField($content_type, 'field_definition');
    $this->addTextField($content_type, 'field_example');
  }

  /**
   * Add text field to the given node type.
   *
   * @param \Drupal\node\NodeTypeInterface $type
   *   Node type object.
   * @param $fieldName
   *   Machine name of the field.
   */
  private function addTextField(NodeTypeInterface $type, $fieldName) {
    $field_storage = FieldStorageConfig::create([
      'field_name' => $fieldName,
      'entity_type' => 'node',
      'type' => 'string_long',
    ]);
    $field_storage->save();
    FieldConfig::create([
      'field_storage' => $field_storage,
      'bundle' => $type->id(),
      'label' => $fieldName,
    ])->save();
  }

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    parent::register($container);
    $container->register('urban_module.service', '\Drupal\tests\urban_module\Kernel\Stub\FakeUrbanDictionaryService');
  }

  /**
   * Tests entity_presave hook.
   */
  public function testPresaveHook() {
    $node = Node::create([
      'type' => 'urban_definition',
      'title' => 'brb',
    ]);
    $node->save();
    $this->assertEquals($node->field_definition->value, 'brb definition');
  }

}
