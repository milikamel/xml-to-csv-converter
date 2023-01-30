<?php

declare(strict_types=1);

namespace App\Formatter;

interface FormatterInterface
{
    public function format(mixed $data): mixed;
}
