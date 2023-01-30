<?php

declare(strict_types=1);

namespace App;

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', true);
ini_set('log_errors', true);
ini_set('error_log', __DIR__ . "/tmp/php-error.log");

use Symfony\Component\Console\Application as MainApplication;
use Symfony\Component\Console\Command\Command;

class Application extends MainApplication
{
    /**
     * @param iterable<Command> $commands
     */
    public function __construct(iterable $commands)
    {
        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct();
    }
}
