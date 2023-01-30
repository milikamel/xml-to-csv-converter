<?php

declare(strict_types=1);

namespace App\Importer;

use App\Exception\InvalidSourceException;

class ImporterHandler
{
    public function __construct(
        private readonly FtpFileStrategy $ftpFileStrategy,
        private readonly LocalFileStrategy $localFileStrategy
    ) {
    }

    /**
     * @throws \App\Exception\InvalidSourceException
     * @throws \App\Exception\FileCurlNotFoundException
     */
    public function import(string $path, string $source): string
    {

        return match ($source) {
            ImporterStrategyInterface::LOCAL => $this->localFileStrategy->import($path),
            ImporterStrategyInterface::FTP => $this->ftpFileStrategy->import($path),
            default => throw new InvalidSourceException('please provide source type local or ftp'),
        };
    }
}
