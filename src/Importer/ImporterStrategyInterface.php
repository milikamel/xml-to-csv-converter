<?php

declare(strict_types=1);

namespace App\Importer;

interface ImporterStrategyInterface
{
    public const LOCAL = 'local';
    public const FTP = 'ftp';

    public function import(string $path): string;
}
