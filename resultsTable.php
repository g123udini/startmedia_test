<?php

use TestJuniorMaster\DataImporter;
use TestJuniorMaster\Exception\SourceFileException;
use TestJuniorMaster\Member;
use TestJuniorMaster\MembersPool;

require_once 'vendor/autoload.php';

$importer = new DataImporter();
try {
    $attemptsArray = $importer->importFiles('testData/data_attempts.json');
    $membersDataArray = $importer->importFiles('testData/data_cars.json');
} catch (SourceFileException $exception) {
    throw new SourceFileException('Загрузить данные из файлов не удалось');
}

$membersPool = new MembersPool();

$membersResultsById = [];
foreach ($attemptsArray as $attempt) {
    $membersResultsById[$attempt['id']][] = $attempt['result'];
}

foreach ($membersDataArray as $memberInfo) {
    $member = new Member($memberInfo['id'], $memberInfo['name'], $memberInfo['city'], $memberInfo['car'], $membersResultsById[$memberInfo['id']]);
    $membersPool->setMember($member);
};
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
        $i = 1;
        foreach ($member->getAttempts() as $attempt): ?>
            <th><a href="resultsTable.php?sort=<?= $i ?>">Попытка № <?= $i++ ?></a></a></th>
        <?php endforeach; ?>
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