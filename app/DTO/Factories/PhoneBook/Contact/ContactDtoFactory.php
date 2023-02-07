<?php

namespace App\DTO\Factories\PhoneBook\Contact;

use App\DTO\Factories\PhoneBook\Number\NumberDtoFactory;
use App\DTO\PhoneBook\Contact\ContactDto;

class ContactDtoFactory
{
    /**
     * @description Создание DataTransferObject из массива (отвалидированные данные запроса создания или обновления контакта) для передачи в методы создания или обновления контакта
     *
     * @param array $data
     * @return ContactDto
     */
    public static function fromArray(array $data): ContactDto
    {
        $dto = new ContactDto();

        $dto->firstName = $data['firstName'];
        $dto->secondName = $data['secondName'];
        $dto->lastName = $data['lastName'];
        foreach ($data['numbers'] as $number)
        {
            $dto->numbers[] = NumberDtoFactory::fromArray($number);
        }

        return $dto;
    }
}
