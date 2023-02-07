<?php

namespace App\DTO\PhoneBook\Contact;

/**
 * DataTransferObject Контакта, для того, чтобы не таскать объект запроса по всей логике, а оставлять его только в контроллере
 */
class ContactDto
{
    /**
     * @description Имя контакта
     *
     * @var string
     */
    public string $firstName;
    /**
     * @description Отчество контакта, может отсутсвовать
     *
     * @var string|null
     */
    public ?string $secondName = null;
    /**
     * @description Фамилия контакта
     *
     * @var string
     */
    public string $lastName;
    /**
     * @description Номера контакта
     *
     * @var array
     */
    public array $numbers;
}
