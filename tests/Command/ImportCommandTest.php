<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Application;
use App\Command\ImportCommand;
use App\Converter\ConverterInterface;
use App\Converter\XmlToCsvConverter;
use App\Exception\FileNotFoundException;
use App\Exception\InvalidSourceException;
use App\Formatter\CsvFormatter;
use App\Importer\FtpFileStrategy;
use App\Importer\ImporterHandler;
use App\Importer\LocalFileStrategy;
use App\Parser\XmlParser;
use App\Validator\XmlFileValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCommandTest extends TestCase
{
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $xmlParser = new XmlParser(new XmlFileValidator());
        $csvFormatter = new CsvFormatter();
        $converter = new XmlToCsvConverter($xmlParser, $csvFormatter);
        $importerHandler = new ImporterHandler(
            new FtpFileStrategy(),
            new LocalFileStrategy()
        );

        $importCommand = new ImportCommand(
            $importerHandler,
            $converter
        );

        $application = new Application([$importCommand]);
        $command = $application->get(ImportCommand::COMMAND_NAME);
        $this->commandTester = new CommandTester($command);
    }

    public function testCommand(): void
    {
        $this->commandTester->execute([
            '--source' => 'local',
            'file-path' => 'import_test.xml']);

        self::assertFileExists('../../output/import_test.csv');
    }

    public function testInvalidSource(): void
    {
        try {
            $this->commandTester->execute([
                '--source' => 'None',
                'file-path' => 'import_test.xml']);
        } catch (\Throwable $ex) {
            $this->assertInstanceOf(InvalidSourceException::class, $ex);
        }
    }

    public function testFileInvalidPath(): void
    {
        try {
            $this->commandTester->execute([
                '--source' => 'local',
                'file-path' => 'whatever']);
        } catch (\Throwable $ex) {
            $this->assertInstanceOf(FileNotFoundException::class, $ex);
        }
    }
}
