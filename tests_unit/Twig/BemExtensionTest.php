<?php

namespace AKlump\Bem\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Html output.
 */
final class BemExtensionTest extends TestCase {

  public function testClassesAreRenderedToHtmlAsExpected() {
    $html = $this->getPageHtml();
    $this->assertStringContainsString('"story-section js-story-section story-section--th-summary story-section--lang-en"', $html);
    $this->assertStringContainsString('"story-section__width component__width"', $html);
    $this->assertStringContainsString('"story-section__item story-section__item--first"', $html);
    $this->assertStringContainsString('"story-section__item"', $html);
    $this->assertStringContainsString('"story-section__item story-section__item--last"', $html);
  }

  public function testPhpDevServerIsRunning() {
    $this->assertNotNull($this->getPageHtml(), 'Assert bin/run_twig_example.sh is running.');
  }

  private function getPageHtml(): ?string {
    $webpage = curl_init('http://127.0.0.1:8080/');
    curl_setopt($webpage, CURLOPT_RETURNTRANSFER, TRUE);
    $html = curl_exec($webpage);
    curl_close($webpage);

    return FALSE === $html ? NULL : $html;
  }
}
