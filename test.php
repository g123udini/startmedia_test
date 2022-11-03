<?php
require_once 'src/DataImporter.php';
require_once 'src/Member.php';

$file = new SplFileObject('data_attempts.json');

$importer = new DataImporter();
$attempts_array = $importer->importFiles('data_attempts.json');
$cars_array = $importer->importFiles('data_cars.json');

foreach ($cars_array as $carInfo) {
    $member = new Member($carInfo['id'], $carInfo['name'], $carInfo['city'], $carInfo['car']);
    $members_array[] = $member;
};

foreach ($members_array as $member) {
    $member->loadAttempts($attempts_array);
    $members_array[] = $member;
}
//var_dump($members_array);
?>
<table>
    <tr>
        <th>Имя</th>
        <th>Город</th>
        <th>Машина</th>
        <th>Попытка</th>
    </tr>
      <?php foreach ($members_array as $member): ?>
    <tr><td><?= $member->getName() ?></td><td><?= $member->getCity() ?></td><td><?= $member->getCar() ?></td><td><?= var_dump($member->getAttempts()) ?></td></tr>
      <?php endforeach; ?>
</table>