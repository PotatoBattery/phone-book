<?php

namespace App\DTO\Factories\PhoneBook\Number;

use App\DTO\PhoneBook\Number\NumberDto;

class NumberDtoFactory
{
    /**
     * @description Создание DataTransferObject из массива для передачи в методы создания или обновления контакта
     *
     * @param array $data
     * @return NumberDto
     */
    public static function fromArray(array $data): NumberDto
    {
        $dto = new NumberDto();

        $dto->number = $data['value'];
        $dto->id = array_key_exists('id', $data) ? $data['id'] : null;

        return $dto;
    }
}
