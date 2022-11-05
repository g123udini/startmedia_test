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