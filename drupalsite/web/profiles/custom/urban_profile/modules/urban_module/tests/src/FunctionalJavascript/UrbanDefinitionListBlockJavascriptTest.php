<?php

namespace Drupal\tests\urban_module\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests urban definition list block (including JS functionality).
 */
class UrbanDefinitionListBlockJavascriptTest extends WebDriverTestBase {

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
      'title' => 'LMK',
    ]);

    $this->drupalGet('<front>');

    $assertSession = $this->assertSession();
    $assertSession->pageTextContains('brb');
    $assertSession->pageTextContains('LMK');
    $assertSession->pageTextNotContains('Acronym for "be right back"');
    $assertSession->pageTextNotContains('Let me know');

    $this->click('a[href="/urban/definition/1"]');
    $assertSession->assertWaitOnAjaxRequest();
    $assertSession->pageTextContains('Acronym for "be right back"');

    $this->click('a[href="/urban/definition/2"]');
    $assertSession->assertWaitOnAjaxRequest();
    $assertSession->pageTextContains('Let me know');
  }

}
