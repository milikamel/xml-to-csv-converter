<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application;
use App\Converter\ConverterInterface;
use App\Converter\XmlToCsvConverter;
use Symfony\Component\Console\Command\Command;

return static function (ContainerConfigurator $configurator): void {

    $container = $configurator->services()->defaults()
        ->autoconfigure()
        ->autowire();

    $container->instanceof(Command::class)
        ->tag('application.command');

    $container->load('App\\', '../src/');

    $container->set(Application::class)
        ->public()
        ->args([tagged_iterator('application.command')]);

    $container->alias(ConverterInterface::class, XmlToCsvConverter::class);
};
