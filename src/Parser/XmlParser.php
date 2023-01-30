<?php

declare(strict_types=1);

namespace App\Parser;

use App\Exception\FileContentException;
use App\Validator\XmlFileValidator;
use Generator;
use SimpleXMLElement;
use XMLReader;

class XmlParser implements ParserInterface
{
    public function __construct(
        private readonly XmlFileValidator $xmlFileValidator,
    ) {
    }

    /**
     * @throws \App\Exception\NotRegularFileException
     * @throws \App\Exception\FileTypeException
     * @throws \App\Exception\FileNotFoundException
     * @throws \App\Exception\FileContentException
     * @throws \Exception
     */
    public function parse(string $path): Generator
    {
        $this->xmlFileValidator->isValid($path);
        $xmlReader = new XMLReader();

        if (!$xmlReader->open($path)) {
            throw new FileContentException('error fetching the content of the file');
        }

        while ($xmlReader->read()) {
            if ($xmlReader->localName === 'item') {
                yield new SimpleXMLElement($xmlReader->readOuterXml());
            }
        }

        $xmlReader->close();
    }
}
