<?php

namespace App\Services\Interfaces\PhoneBook\Contact;

use App\DTO\PhoneBook\Contact\ContactDto;
use App\Models\PhoneBook\Contact;
use Illuminate\Database\Eloquent\Collection;

interface ContactServiceInterface
{
    /**
     * @description Метод для получения всех контактов пользователя или всех избранных контактов пользователя
     *
     * @param int $userId
     * @param int $favorite
     * @param string $searchQuery
     * @return Collection
     */
    public function getContacts(int $userId, int $favorite, string $searchQuery): Collection;

    /**
     * @description Метод для удаления контакта
     *
     * @param int $contactId
     * @return void
     */
    public function removeContact(int $contactId): void;

    /**
     * @description Метод для получения контакта по идентификатору
     *
     * @param int $id
     * @return Contact
     */
    public function getContactById(int $id): Contact;

    /**
     * @description Метод для создания контакта
     *
     * @param ContactDto $data
     * @param int $userId
     * @return Contact
     */
    public function createContact(ContactDto $data, int $userId): Contact;

    /**
     * @description Метод для обновления контакта
     *
     * @param ContactDto $data
     * @param int $contactId
     * @return void
     */
    public function updateContact(ContactDto $data, int $contactId): void;

    /**
     * @description Добавление контакта в избранное или удаление его из этого списка
     *
     * @param int $favorite
     * @param int $contactId
     * @return void
     */
    public function changeFavoriteContact(int $favorite, int $contactId): void;
}
