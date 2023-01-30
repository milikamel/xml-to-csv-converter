<?php

declare(strict_types=1);

namespace App\Formatter;

use SimpleXMLElement;

class CsvFormatter implements FormatterInterface
{
    /**
     * @param SimpleXMLElement $data
     * @return array<int,mixed>
     */
    public function format(mixed $data): mixed
    {
        return $this->xmlToArray($data);
    }

    /**
     * @param \SimpleXMLElement $simpleXMLElement
     * @return array<int, array<int, int|string>>
     */
    public function formatCsvColumnsHeader(SimpleXMLElement $simpleXMLElement): array
    {
        return array(array_keys((array)$simpleXMLElement->children()));
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    private function xmlToArray(SimpleXMLElement $simpleXMLElement): array
    {
        $nodeValues = [];

        foreach ($simpleXMLElement->children() as $node) {
            $nodeValues[] = $this->nodeFormatter($node->__toString());
        }

        return array($nodeValues);
    }


    private function nodeFormatter(string $node): string
    {
        $node = preg_replace('/\r|\n/', '', $node);

        return trim((string)$node);
    }
}
