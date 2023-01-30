<?php

declare(strict_types=1);

namespace App\Converter;

use App\Exception\FileNotFoundException;
use App\Formatter\CsvFormatter;
use App\Helper\FilePathHelper;
use App\Parser\XmlParser;

class XmlToCsvConverter implements ConverterInterface
{
    public function __construct(
        private readonly XmlParser $xmlParser,
        private readonly CsvFormatter $csvFormatter
    ) {
    }

    /**
     * @throws \App\Exception\NotRegularFileException
     * @throws \App\Exception\FileTypeException
     * @throws \App\Exception\FileNotFoundException
     * @throws \App\Exception\FileContentException
     * @throws \Exception
     */
    public function convert(string $path): void
    {
        $generator = $this->xmlParser->parse($path);

        if (!$generator->valid()) {
            return;
        }

        $options = [
            FilePathHelper::FOLDER_OPTION => 'output',
        ];

        $file = FilePathHelper::getDesiredPath($path, $options);

        $f = fopen($file . '.csv', 'w');

        if (!$f) {
            throw new FileNotFoundException();
        }

        $columns = $this->csvFormatter->formatCsvColumnsHeader(
            $generator->current()
        );

        array_map(
            static fn(mixed $row) => fputcsv($f, $row),
            $columns
        );

        $generator->rewind();

        while ($generator->valid()) {
            $formatterCsvArray = $this->csvFormatter->format($generator->current());
            foreach ($formatterCsvArray as $row) {
                if (!$row) {
                    continue;
                }

                fputcsv($f, $row);
            }

            $generator->next();
        }

        fclose($f);
    }
}
