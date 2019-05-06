<?php

namespace Drupal\urban_module\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Ajax controller used on 'urban_definition_list_block' block.
 */
class UrbanDefinitionAjaxController {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')
        ->getStorage('node')
    );
  }

  /**
   * Get urban definition HTML for 'urban_definition_list_block' block.
   *
   * @param \Drupal\Core\Entity\EntityInterface $node
   *   Urban definition node.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Ajax response with urban definition HTML.
   */
  public function ajaxDefinitionHtml(EntityInterface $node) {
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new HtmlCommand("#definition-{$node->id()}", "<div>" . $node->field_definition->value . "</div>"));
    return $ajax_response;
  }

}
