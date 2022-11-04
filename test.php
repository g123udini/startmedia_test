<?php
require_once 'src/DataImporter.php';
require_once 'src/Member.php';

$file = new SplFileObject('data_attempts.json');

$importer = new DataImporter();
$attempts_array = $importer->importFiles('data_attempts.json');
$members_data_array = $importer->importFiles('data_cars.json');

foreach ($members_data_array as $memberInfo) {
    $member = new Member($memberInfo['id'], $memberInfo['name'], $memberInfo['city'], $memberInfo['car']);
    $member->loadAttempts($attempts_array);
    $members_array[] = $member;
};

usort($members_array, function ($member1, $member2) {
    if($member1->getScoreSum() == $member2->getScoreSum()) return 0;
    return ($member1->getScoreSum() > $member2->getScoreSum()) ? -1 : 1;
})

?>
<table>
    <tr>
        <th>Имя</th>
        <th>Город</th>
        <th>Машина</th>
        <th>Попытка № 1</th>
        <th>Попытка № 2</th>
        <th>Попытка № 3</th>
        <th>Попытка № 4</th>
        <th>Сумма очков</th>
    </tr>
      <?php foreach ($members_array as $member): ?>
    <tr><td><?= $member->getName() ?></td><td><?= $member->getCity() ?></td><td><?= $member->getCar() ?></td><td><?= $member->getAttempts()['0'] ?></td><td><?= $member->getAttempts()['1'] ?></td><td><?= $member->getAttempts()['2'] ?></td><td><?= $member->getAttempts()['3'] ?></td><td><?= $member->getScoreSum() ?></td></tr>
      <?php endforeach; ?>
</table>