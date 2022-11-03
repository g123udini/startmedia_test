<?php

class DataImporter
{
    public function importFiles($fileName)
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