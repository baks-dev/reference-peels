<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BaksDev\Reference\Peel\Type\Peel;
use BaksDev\Reference\Peel\Type\PeelType;
use Symfony\Config\DoctrineConfig;

return static function(DoctrineConfig $doctrine) {

    $doctrine->dbal()->type(Peel::TYPE)->class(PeelType::class);

};
