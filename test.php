<?php
require_once 'src/DataImporter.php';
require_once 'src/Member.php';
require_once 'src/MembersStack.php';

$importer = new DataImporter();
try {
    $attempts_array = $importer->importFiles('data_attempts.json');
    $members_data_array = $importer->importFiles('data_cars.json');
} catch (SourceFileException $exception) {
    throw new SourceFileException('Загрузить данные из файлов не удалось');
}

$membersStack = new MembersStack();

foreach ($members_data_array as $memberInfo) {
    $member = new Member($memberInfo['id'], $memberInfo['name'], $memberInfo['city'], $memberInfo['car']);
    $member->loadAttempts($attempts_array);
    $membersStack->setMember($member);
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
            <th><a href="test.php?sort=<?= $i ?>">Попытка № <?= $i++ ?></a></a></th>
        <?php endforeach; ?>
        <th><a href="test.php?sort=sum">Сумма очков</a></th>
    </tr>
    <?php
    $i = 1;
    foreach ($membersStack->getSortByQuery($_GET['sort'] ?? null) as $member):?>
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