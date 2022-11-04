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
     * Сортирует участника по запросу
     * @param string $get Запрос sort из строки запроса
     * @return array|void
     */
    public function getSortByQuery(string $get): ?array
    {
        switch ($get) {
            case 'first':
                return $this->getSortedMembersByFirstAttempt();
            case 'second':
                return $this->getSortedMembersBySecondAttempt();
            case 'third':
                return $this->getSortedMembersByThirdAttempt();
            case 'fourth':
                return $this->getSortedMembersByFourthAttempt();
            case 'sum':
                return $this->getSortedMembersByScoreSum();
        }
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

    private function getSortedMembersByFirstAttempt(): array
    {
        usort($this->members, function ($member1, $member2) {
            if($member1->getFirstAttempt() == $member2->getFirstAttempt()) return 0;
            return ($member1->getFirstAttempt() > $member2->getFirstAttempt()) ? -1 : 1;
        });

        return $this->members;
    }

    private function getSortedMembersBySecondAttempt(): array
    {
        usort($this->members, function ($member1, $member2) {
            if($member1->getSecondAttempt() == $member2->getSecondAttempt()) return 0;
            return ($member1->getSecondAttempt() > $member2->getSecondAttempt()) ? -1 : 1;
        });

        return $this->members;
    }

    private function getSortedMembersByThirdAttempt(): array
    {
        usort($this->members, function ($member1, $member2) {
            if($member1->getThirdAttempt() == $member2->getThirdAttempt()) return 0;
            return ($member1->getThirdAttempt() > $member2->getThirdAttempt()) ? -1 : 1;
        });

        return $this->members;
    }

    private function getSortedMembersByFourthAttempt(): array
    {
        usort($this->members, function ($member1, $member2) {
            if($member1->getFourthAttempt() == $member2->getFourthAttempt()) return 0;
            return ($member1->getFourthAttempt() > $member2->getFourthAttempt()) ? -1 : 1;
        });

        return $this->members;
    }

}