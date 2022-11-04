<?php

class Member
{
    private string $id;
    private string $name;
    private string $city;
    private string $car;
    private array $attempts = [];

    public function __construct($id, $name, $city, $car)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->car = $car;
    }

    /**
     * Загружает заезды в участника
     * @param array $attempts_array Массив заездов из файла
     * @return void
     */
    public function loadAttempts($attempts_array)
    {
        foreach ($attempts_array as $attempt) {
            if ($this->id == $attempt['id']) {
                $this->attempts[] = $attempt['result'];
            }
        }
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
     * @return array Массиво попыток участника
     */
    public function getAttempts(): array
    {
        return $this->attempts;
    }

    /**
     * @return int Сумма очков участника
     */
    public function getScoreSum(): int
    {
        return array_sum($this->attempts);
    }

}