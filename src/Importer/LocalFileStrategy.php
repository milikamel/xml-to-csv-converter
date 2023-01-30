<?php

declare(strict_types=1);

namespace App\Importer;

class LocalFileStrategy implements ImporterStrategyInterface
{
    public function import(string $path): string
    {
        return $path;
    }
}
