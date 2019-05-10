<?php

namespace Drupal\tests\urban_module\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests urban definition list block.
 */
class UrbanDefinitionListBlockTest extends BrowserTestBase {

  protected $profile = 'urban_profile';

  /**
   * Tests that block is correctly displayed on the frontpage.
   */
  public function testBlock() {
    $this->createNode([
      'type' => 'urban_definition',
      'title' => 'brb',
    ]);
    $this->createNode([
      'type' => 'urban_definition',
      'title' => 'lmk',
    ]);

    $this->drupalGet('<front>');

    $assertSession = $this->assertSession();
    $assertSession->pageTextContains('brb');
    $assertSession->pageTextContains('lmk');
  }

}
