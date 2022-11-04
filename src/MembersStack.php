<?php

class MembersStack
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
     * Сортирует участников по запросу
     * @param ?string $get Запрос sort из строки запроса
     * @return array|void
     */
    public function getSortByQuery(?string $get): ?array
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
            if($member1->getScoreSum() == $member2->getScoreSum()) return 0;
            return ($member1->getScoreSum() > $member2->getScoreSum()) ? -1 : 1;
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
            if($member1->getAttempts()[$i] == $member2->getAttempts()[$i]) return 0;
            return ($member1->getAttempts()[$i] > $member2->getAttempts()[$i]) ? -1 : 1;
        });

        return $this->members;
    }

}