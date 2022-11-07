<?php

use TestJuniorMaster\DataImporter;
use TestJuniorMaster\Exception\SourceFileException;
use TestJuniorMaster\Member;
use TestJuniorMaster\MembersPool;

require_once 'vendor/autoload.php';

$importer = new DataImporter();
try {
    $importer->importMembersResults('testData/data_attempts.json');
    $importer->importMembersInfo('testData/data_cars.json');
} catch (SourceFileException $exception) {
    throw new SourceFileException('Загрузить данные из файлов не удалось');
}

$membersPool = $importer->getMembersPool();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Таблица участников</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
<table>
    <caption>Таблица участников заезда</caption>
    <tr>
        <th>Место</th>
        <th>Имя</th>
        <th>Город</th>
        <th>Машина</th>
        <?php
        for ($i = 1; $i <= $membersPool->getFirstMember()->getAttemptsCount(); $i++): ?>
            <th><a href="resultsTable.php?sort=<?= $i ?>">Попытка № <?= $i ?></a></a></th>
        <?php endfor; ?>
        <th><a href="resultsTable.php?sort=sum">Сумма очков</a></th>
    </tr>
    <?php
    $i = 1;
    foreach ($membersPool->getSortByQuery($_GET['sort'] ?? null) as $member):?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $member->getName() ?></td>
            <td><?= $member->getCity() ?></td>
            <td><?= $member->getCar() ?></td>
            <?php foreach ($member->getAttempts() as $attempt): ?>
            <td><?= $attempt ?></td>
            <?php endforeach; ?>
            <td><?= $member->getScoreSum() ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>