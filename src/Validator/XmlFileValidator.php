<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\FileNotFoundException;
use App\Exception\FileTypeException;
use App\Exception\NotRegularFileException;

class XmlFileValidator
{
    private const XML_FILE_TYPE = 'text/xml';

    /**
     * @throws \App\Exception\NotRegularFileException
     * @throws \App\Exception\FileTypeException
     * @throws \App\Exception\FileNotFoundException
     */
    public function isValid(string $path): bool
    {

        if (!file_exists($path)) {
            throw new FileNotFoundException('File doesnt exist');
        }

        if (!is_file($path)) {
            throw new NotRegularFileException('File is not valid, either folder or symlink provided');
        }

        if (mime_content_type($path) !== self::XML_FILE_TYPE) {
            throw new FileTypeException('File type is not valid, please provide an XML file');
        }

        return true;
    }
}
