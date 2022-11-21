<?php
namespace TestJuniorMaster;

class MembersPool
{
    private array $members;

    /**
     * Добавляет участника в стек
     * @param mixed $member
     */
    public function setMember(Member $member): void
    {
        $this->members[] = $member;
    }

    /**
     * Получить первого участника из списка
     * @return Member
     */
    public function getFirstMember(): Member
    {
        return $this->members[0];
    }

    /**
     * Узнать максимальное количество попыток
     * @return int
     */
    public function getMaxAttemptsCount(): int
    {
        $maxAttemptsCount = 0;
        foreach ($this->members as $member) {
            if ($maxAttemptsCount < $member->getAttemptsCount()) {
                $maxAttemptsCount = $member->getAttemptsCount();
            }
        }

        return $maxAttemptsCount;
    }

    /**
     * Добавляет участникам, которые не участвовали в доп. заездах 0
     * @return void
     */
    public function standardizeAttempts(): void
    {
        $maxAttemptsCount = $this->getMaxAttemptsCount();

        foreach ($this->members as $member) {
            if ($maxAttemptsCount > $member->getAttemptsCount()) {
                $member->addEmptyAttempt();
            }
        }
    }

    /**
     * Сортирует участников по запросу
     * @param mixed $get Запрос sort из строки запроса
     * @return array|void
     */
    public function getSortByQuery(mixed $get): ?array
    {
        if ($get === null) {
            return $this->getSortedMembersByScoreSum();
        }
        return $get === 'sum' ? $this->getSortedMembersByScoreSum() : $this->getSortedMembersByAttempt($get - 1);
    }

    /**
     * Сортирует участников помаксимальному счету
     * @return array
     */
    private function getSortedMembersByScoreSum(): array
    {
        usort($this->members, function ($member1, $member2) {

            return $member2->getScoreSum() <=> $member1->getScoreSum();
        });

        return $this->members;
    }

    /**
     * Сортирует участников по номеру переданой попытки
     * @param int $i Номер попытки передаваемый из запроса
     * @return array Отсортированные по очкам попытки
     */
    private function getSortedMembersByAttempt(int $i): array
    {
        usort($this->members, function ($member1, $member2) use ($i) {

            return $member2->getAttempts()[$i] <=> $member1->getAttempts()[$i];
        });

        return $this->members;
    }

}