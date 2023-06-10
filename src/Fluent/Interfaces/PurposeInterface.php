<?php

namespace AKlump\Bem\Fluent\Interfaces;

interface PurposeInterface extends OutputInterface {

  const JS = 1;

  const PLUS_JS = 2;

  const PLUS_GLOBAL = 4;

  public function js(): PurposeInterface;

  public function plusJs(): PurposeInterface;

  public function plusGlobal(): PurposeInterface;

}
