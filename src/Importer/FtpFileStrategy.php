<?php

declare(strict_types=1);

namespace App\Importer;

use App\Exception\FileCurlNotFoundException;
use App\Helper\FilePathHelper;

class FtpFileStrategy implements ImporterStrategyInterface
{
    private const TIMEOUT = 600;

    /**
     * @throws \App\Exception\FileCurlNotFoundException
     */
    public function import(string $path): string
    {
        $options = [
            FilePathHelper::FOLDER_OPTION => 'input',
        ];

        $tmpPath = FilePathHelper::getDesiredPath($path, $options);
        $tmpFile = fopen($tmpPath, 'w+');
        $curl = curl_init($path);

        if ((!$curl) || (!$tmpFile)) {
            unlink($tmpPath);
            throw new FileCurlNotFoundException();
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, self::TIMEOUT);

        curl_setopt($curl, CURLOPT_FILE, $tmpFile);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($curl);

        curl_close($curl);

        fclose($tmpFile);

        if (!filesize($tmpPath)) {
            unlink($tmpPath);
        }

        return $tmpPath;
    }
}
