<?php

namespace App\DTO\PhoneBook\Number;

class NumberDto
{
    /**
     * @description Идентификатор номера
     *
     * @var int|null
     */
    public ?int $id = null;
    /**
     * @description Значение номера
     *
     * @var string
     */
    public string $number;
}
