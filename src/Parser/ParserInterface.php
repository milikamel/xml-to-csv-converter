<?php

declare(strict_types=1);

namespace App\Parser;

use Generator;

interface ParserInterface
{
    public function parse(string $path): Generator;
}
