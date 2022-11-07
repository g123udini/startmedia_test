<?php
namespace TestJuniorMaster;

class Member
{
    private string $id;
    private string $name;
    private string $city;
    private string $car;
    private array $attempts = [];

    public function __construct($id, $name, $city, $car, $attempts)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->car = $car;
        $this->attempts = $attempts;
    }

    /**
     * @return string Имя участника
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string Город участника
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string Id участника
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string Машина участника
     */
    public function getCar(): string
    {
        return $this->car;
    }

    /**
     * @return array Массив попыток участника
     */
    public function getAttempts(): array
    {
        return $this->attempts;
    }

    /**
     * @return int Возвращает количество попыток участника
     */
    public function getAttemptsCount(): int
    {
        return count($this->attempts);
    }

    /**
     * @return int Сумма очков участника
     */
    public function getScoreSum(): int
    {
        return array_sum($this->attempts);
    }

}