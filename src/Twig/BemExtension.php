<?php

namespace AKlump\Bem\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use AKlump\Bem\Twig\TwigBem;

class BemExtension extends AbstractExtension {

  private $block = '';

  private $global = '';

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    $functions = [];

    $functions[] = new TwigFunction('bem_set_block', function (string $block) {
      $this->block = $block;
    });

    $functions[] = new TwigFunction('bem_set_global', function (string $global) {
      $this->global = $global;
    });

    $functions[] = new TwigFunction('bem_block', function (array $context) {
      return $this->create()->block();
    }, ['needs_context' => TRUE]);

    $functions[] = new TwigFunction('bem_element', function (array $context, string $element_stub) {
      return $this->create()->element($element_stub);
    }, ['needs_context' => TRUE]);

    return $functions;
  }

  private function create(): TwigBem {
    $bem = new TwigBem($this->block, $this->global);

    return $bem;
  }

}
