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
<table>
    <tr>
        <th>Место</th>
        <th>Имя</th>
        <th>Город</th>
        <th>Машина</th>
        <th><a href="test.php?sort=first">Попытка № 1</a></a></th>
        <th><a href="test.php?sort=second">Попытка № 2</a></th>
        <th><a href="test.php?sort=third">Попытка № 3</a></th>
        <th><a href="test.php?sort=fourth">Попытка № 4</a></th>
        <th><a href="test.php?sort=sum">Сумма очков</a></th>
    </tr>
      <?php
      $i = 1;
      foreach ($membersStack->getSortByQuery($_GET['sort']) as $member):?>
    <tr><td><?= $i++ ?></td><td><?= $member->getName() ?></td><td><?= $member->getCity() ?></td><td><?= $member->getCar() ?></td><td><?= $member->getFirstAttempt() ?></td><td><?= $member->getSecondAttempt()?></td><td><?= $member->getThirdAttempt() ?></td><td><?= $member->getFourthAttempt() ?></td><td><?= $member->getScoreSum() ?></td></tr>
      <?php endforeach; ?>
</table>
