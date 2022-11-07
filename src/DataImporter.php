<?php

namespace TestJuniorMaster;

use TestJuniorMaster\Exception\SourceFileException;
use Throwable;

class DataImporter
{
    private array $membersResults;
    private array $membersInfo;

    /**
     * Импортирует информацию об участнике из файла
     * @param string $fileName Имя файла
     * @return void
     * @throws SourceFileException Открыть файл на чтение не удалось
     */
    public function importMembersInfo($fileName): void
    {

        $this->membersInfo = $this->importFiles($fileName);
    }

    /**
     * Импортирует попытки и формирует их в массив ID участника => попытки
     * @param string $fileName Имя файла
     * @return void
     * @throws SourceFileException Файл не удалось открыть на чтение
     */
    public function importMembersResults($fileName): void
    {
        $data = $this->importFiles($fileName);

        foreach ($data as $attempt) {
            $membersResultsById[$attempt['id']][] = $attempt['result'];
        }

        $this->membersResults = $membersResultsById;
    }

    /**
     * Создает полный пул участников соревнований с информацией о них
     * @return MembersPool
     */
    public function getMembersPool() {
        $membersPool = new MembersPool();

        foreach ($this->membersInfo as $memberInfo) {
            $member = new Member($memberInfo['id'], $memberInfo['name'], $memberInfo['city'], $memberInfo['car'], $this->membersResults[$memberInfo['id']]);
            $membersPool->setMember($member);
        }

        return $membersPool;
    }

    /**
     * Импортирует данные из json файлов
     * @param string $fileName Путь к файлу
     * @return array Данные из файла в формате массива
     * @throws SourceFileException Не удалось открыть файл на чтение
     */
    private function importFiles($fileName): array
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