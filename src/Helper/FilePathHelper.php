<?php

declare(strict_types=1);

namespace App\Helper;

final class FilePathHelper
{
    public const FOLDER_OPTION = 'folder';
    /**
     * @param array<string, string> $options
     */
    public static function getDesiredPath(string $path, array $options = []): string
    {
        $rootDir = realpath(__DIR__ . '/..' . '/..');

        return $rootDir
            . '/'
            . $options[self::FOLDER_OPTION]
            . '/'
            . basename($path, '.xml');
    }
}
