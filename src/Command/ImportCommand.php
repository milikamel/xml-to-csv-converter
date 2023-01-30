<?php

declare(strict_types=1);

namespace App\Command;

use App\Converter\ConverterInterface;
use App\Importer\ImporterHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCommand extends Command
{
    public const FILE_ARGUMENT_NAME = 'file-path';
    public const FILE_OPTION_SOURCE = 'source';
    public const COMMAND_NAME = 'task:import';

    public function __construct(
        private readonly ImporterHandler $importerHandler,
        private readonly ConverterInterface $converter
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this
            ->setDescription(
                'This command process a local or remote XML file and store the data in a CSV file,
                to get a remote file you send as path something like ftp://example.com/ and specify in 
                '
            )
            ->addArgument(
                self::FILE_ARGUMENT_NAME,
                InputArgument::REQUIRED,
                'path of the file'
            )
            ->addOption(
                self::FILE_OPTION_SOURCE,
                null,
                InputOption::VALUE_REQUIRED,
                'Provide local or ftp as source'
            );
    }

    /**
     * @throws \App\Exception\InvalidSourceException
     * @throws \App\Exception\FileCurlNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getArgument(self::FILE_ARGUMENT_NAME);
        $source = $input->getOption(self::FILE_OPTION_SOURCE);

        if (!$path) {
            $io->error('please provide a file path!');
            return 1;
        }

        if (!$source) {
            $io->error('please provide source local or ftp');
            return 1;
        }

        $path = $this->importerHandler->import($path, $source);

        $this->converter->convert($path);

        $io->success('File successfully imported and converted to CSV saved under /src/xml_data_importer/output/');

        return 0;
    }
}
