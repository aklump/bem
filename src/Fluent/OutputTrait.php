<?php

namespace AKlump\Bem\Fluent;

use AKlump\Bem\Fluent\Interfaces\BaseInterface;
use AKlump\Bem\Fluent\Interfaces\PurposeInterface;


trait OutputTrait {

  /**
   * Return all classes representing the state.
   *
   * The order of the classes will alphabetical, however they are first grouped
   * in this order and then alphabetized within the group: *, js-*, global*.
   *
   * @return array
   *   The array of classes based on the state.
   *
   * @see \AKlump\Bem\Fluent\OutputTrait::sort
   */
  public function toArray(): array {
    $state = $this->state->all();
    $style = $this->state->getStyle();
    $block = $style->normalizeBlock($state['block']);

    switch ($this->state->getType()) {
      case BaseInterface::BLOCK:
        $classes = [$block];
        break;

      case BaseInterface::ELEMENT:
        $classes = [
          $block . $style->element() . $style->normalizeElementStub($state['value']),
        ];
        break;
    }

    if (!empty($state['modifier'])) {
      $classes = $this->getModifierClasses($classes, $style->normalizeModifierStub($state['modifier']));
    }
    elseif (!empty($state['plusModifier'])) {
      $classes = array_merge($classes, $this->getModifierClasses($classes, $style->normalizeModifierStub($state['plusModifier'])));
    }

    $purpose = $this->state->getPurpose();

    // Globals have to come after modifiers, so modifiers can be globalized.
    if ($purpose & PurposeInterface::PLUS_GLOBAL) {
      $classes = array_merge($classes, $this->getGlobalClasses());
    }

    // JS processing must come last, because it applies to all classes that can
    // be generated, e.g. base and global.  It's not logical to have both
    // PLUS_JS and JS in the output, but it is possible so we use if...else to
    // keep the output logical as opposed to if...if, which could produce
    // duplicate classes.
    if ($purpose & PurposeInterface::PLUS_JS) {
      $classes = array_merge($classes, $this->getJsClasses($classes));
    }
    elseif ($purpose & PurposeInterface::JS) {
      $classes = $this->getJsClasses($classes);
    }

    if (!isset($classes)) {
      return [];
    }

    return $this->sort($classes);
  }

  private function getModifierClasses(array $base_classes, string $modifier) {
    return array_map(function ($base_class) use ($modifier) {
      return $base_class . $this->state->getStyle()->modifier() . $modifier;
    }, $base_classes);
  }

  private function getJsClasses(array $base_classes) {
    return array_map(function ($base_class) {
      return $this->state->getStyle()->javascript() . $base_class;
    }, $base_classes);
  }

  private function getGlobalClasses() {
    $global_state = clone $this->state;
    $global_purpose = $global_state->getPurpose() & ~PurposeInterface::PLUS_GLOBAL;
    $global_purpose &= ~PurposeInterface::PLUS_JS;
    $global_purpose &= ~PurposeInterface::JS;
    $global_state->set('purpose', $global_purpose);
    $global_state->set('block', $global_state->getGlobal());
    $output = new BemOutput($global_state);

    return $output->toArray();
  }

  /**
   * Sort classes in this order *, js-*, <global>*
   *
   * @param array $classes
   *   An array of classes to sort.
   *
   * @return array
   *   The sorted classes array.
   */
  private function sort(array $classes): array {
    uasort($classes, function ($a, $b) {
      $js = $this->state->getStyle()->javascript();
      $global = $this->state->getGlobal();
      if (strpos($a, $js) === 0) {
        $a = 1;
      }
      elseif (strpos($a, $global) === 0) {
        $a = 2;
      }
      else {
        $a = 0;
      }
      if (strpos($b, $js) === 0) {
        $b = 1;
      }
      elseif (strpos($b, $global) === 0) {
        $b = 2;
      }
      else {
        $b = 0;
      }

      return $a - $b;
    });

    return $classes;
  }

  public function toString(): string {
    return implode(' ', $this->toArray());

  }

  public function __toString() {
    return $this->toString();
  }

}
