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

    public function loadAttempts($attempts_array)
    {
        foreach ($attempts_array as $attempt) {
            if ($this->id == $attempt['id']) {
                $this->attempts[] = $attempt['result'];
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCar(): string
    {
        return $this->car;
    }

    /**
     * @return array
     */
    public function getAttempts(): array
    {
        return $this->attempts;
    }
}