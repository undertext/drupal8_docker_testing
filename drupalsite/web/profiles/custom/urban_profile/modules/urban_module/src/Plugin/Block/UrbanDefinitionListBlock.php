<?php

namespace Drupal\urban_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a UrbanDefinitionListBlock.
 *
 * @Block(
 *   id = "urban_definition_list_block",
 *   admin_label = @Translation("Urban definition list"),
 *   category = @Translation("UB"),
 * )
 */
class UrbanDefinitionListBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Node storage.
   *
   * @var \Drupal\node\NodeStorageInterface
   */
  private $nodeStorage;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityStorageInterface $node_storage) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->nodeStorage = $node_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('entity.manager')
      ->getStorage('node'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#cache' => [
        'tags' => ['node_list'],
      ],
      '#attached' => ['library' => ['core/drupal.ajax']],
    ];

    foreach ($this->getLatestDefinitions() as $definition) {
      $build['#items'][] = [
        '#title' => $definition->getTitle(),
        '#type' => 'link',
        '#attributes' => ['class' => ['use-ajax']],
        '#url' => Url::fromRoute('urban_module.ajax_definition', ['node' => $definition->id()]),
        '#suffix' => "<div id='definition-{$definition->id()}'></div>",
      ];
    }
    return $build;
  }

  /**
   * Get latest urban dictionary definitions.
   *
   * @return \Drupal\Core\Entity\EntityInterface[]
   *   Latest urban dictionary definitions.
   */
  private function getLatestDefinitions() {
    $ids = $this->nodeStorage->getQuery()
      ->condition('type', 'urban_definition')
      ->sort('created')
      ->execute();

    return $this->nodeStorage->loadMultiple($ids);
  }

}
