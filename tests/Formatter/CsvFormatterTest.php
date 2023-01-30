<?php

declare(strict_types=1);

namespace App\Tests\Formatter;

use App\Formatter\CsvFormatter;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use XMLReader;

class CsvFormatterTest extends TestCase
{
    private CsvFormatter $csvFormatter;

    protected function setUp(): void
    {
        $this->csvFormatter = new CsvFormatter();
    }

    /**
     * @throws \Exception
     */
    public function testFormat(): void
    {
        $expectedArray = [];
        $expectedArray[] = [
            "342",
            "Nestle Hot Chocolate",
            "5000081171",
            "Nestle's Rich Hot Chocolate 50 Packets",
            "",
            "Nestle's Rich Hot Chocolate 50 Packets bulk quantity prepare 50 individual servings of milk chocolate instant hot cocoa from Nestle Hot Chocolate.",
            "11.9900",
            "http://www.coffeeforless.com/nestles-milk-hot-chocolate-50-packets.html",
            "http://mcdn.coffeeforless.com/media/catalog/product//n/e/nestle-hot-chocolate-mix-50-packets.png",
            "Nestle",
            "5",
            "2",
            "50",
            "",
            "",
            "Yes",
            "1",
            "0"
        ];

        if (!$this->getXmlElement()) {
            return;
        }

        $result = $this->csvFormatter->format($this->getXmlElement());

        self::assertEquals($result, $expectedArray);
    }

    public function testFormatKey(): void
    {
        $expectedArray = [];
        $expectedArray[] = [
            "entity_id",
            "CategoryName",
            "sku",
            "name",
            "description",
            "shortdesc",
            "price",
            "link",
            "image",
            "Brand",
            "Rating",
            "CaffeineType",
            "Count",
            "Flavored",
            "Seasonal",
            "Instock",
            "Facebook",
            "IsKCup"
        ];

        if (!$this->getXmlElement()) {
            return;
        }

        $result = $this->csvFormatter->formatCsvColumnsHeader($this->getXmlElement());

        self::assertEquals($result, $expectedArray);
    }

    private function getXmlElement(): ?SimpleXMLElement
    {

        $xmlReader = new XMLReader();
        $xmlReader->open(__DIR__ . '/csv_formatter_test.xml');
        $xmlReader->read();

        if ($xmlReader->localName === 'item') {
            return new SimpleXMLElement($xmlReader->readOuterXml());
        }

        return null;
    }
}
