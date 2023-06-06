<?php

namespace AKlump\Bem\Tests\TestTraits;


trait AssertTrait {

  public function assertSameClassStringAnyOrder(string $expected_classes, $result) {
    $expected_classes = explode(' ', $expected_classes);
    $actual_classes = explode(' ', $result);
    $this->assertCount(count($expected_classes), $actual_classes);
    foreach ($expected_classes as $expected_class) {
      $this->assertContains($expected_class, $actual_classes);
    }
  }

}
