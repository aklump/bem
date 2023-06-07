<?php

namespace AKlump\Bem\Twig;

use AKlump\Bem\FluentBem;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BemExtension extends AbstractExtension {

  private $bem;

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    $functions = [];

    $twig_to_fluent_map = [
      'bem_set_block' => 'setBlock',
      'bem_set_global_block' => 'setGlobalBlock',
      'bem_block' => 'block',
      'bem_element' => 'element',
    ];
    foreach ($twig_to_fluent_map as $twig_function_name => $class_method) {
      $functions[] = new TwigFunction($twig_function_name, function () use ($class_method) {
        return $this->invokeClassMethod($class_method, func_get_args());
      }, ['needs_context' => TRUE]);
    }

    return $functions;
  }

  public function invokeClassMethod($method, $args) {
    $context = array_shift($args);
    $this->bem = $this->bem ?? new FluentBem();

    return call_user_func_array([$this->bem, $method], $args);
  }

}
