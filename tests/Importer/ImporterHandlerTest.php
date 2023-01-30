<?php

declare(strict_types=1);

namespace App\Tests\Importer;

use App\Importer\FtpFileStrategy;
use App\Importer\ImporterHandler;
use App\Importer\ImporterStrategyInterface;
use App\Importer\LocalFileStrategy;
use PHPUnit\Framework\TestCase;

class ImporterHandlerTest extends TestCase
{
    private ImporterHandler $importerHandler;

    private FtpFileStrategy $ftpFileStrategy;

    private LocalFileStrategy $localFileStrategy;

    protected function setUp(): void
    {
        $this->ftpFileStrategy = $this->createMock(FtpFileStrategy::class);
        $this->localFileStrategy = $this->createMock(LocalFileStrategy::class);
        $this->importerHandler = new ImporterHandler(
            $this->ftpFileStrategy,
            $this->localFileStrategy
        );
    }

    /**
     * @throws \App\Exception\InvalidSourceException
     * @throws \App\Exception\FileCurlNotFoundException
     */
    public function testLocalImportHandler(): void
    {

        $path = 'path.xml';
        $source = ImporterStrategyInterface::LOCAL;

        /** @phpstan-ignore-next-line */
        $this->localFileStrategy->expects($this->once())->method('import')->with($path)->willReturn($path);

        self::assertEquals($path, $this->importerHandler->import($path, $source));
    }

    /**
     * @throws \App\Exception\InvalidSourceException
     * @throws \App\Exception\FileCurlNotFoundException
     */
    public function testFtpImportHandler(): void
    {

        $path = 'path.xml';
        $source = ImporterStrategyInterface::FTP;

        /** @phpstan-ignore-next-line */
        $this->ftpFileStrategy->expects($this->once())->method('import')->with($path)->willReturn($path);

        self::assertEquals($path, $this->importerHandler->import($path, $source));
    }
}
