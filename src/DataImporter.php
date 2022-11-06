<?php

namespace TestJuniorMaster;

use TestJuniorMaster\Exception\SourceFileException;
use Throwable;

class DataImporter
{
    /**
     * Импортирует данные из json файлов
     * @param string $fileName Путь к файлу
     * @return array Данные из файла в формате массива
     * @throws SourceFileException
     */
    public function importFiles($fileName): array
    {
        try {
            $json = file_get_contents($fileName);
        } catch (Throwable $exception) {
            throw new SourceFileException("Не прочитать файл");
        }
        $data = json_decode($json, true);

        return $data;
    }


}