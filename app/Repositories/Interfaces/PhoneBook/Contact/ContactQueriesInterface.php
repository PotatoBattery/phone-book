<?php

namespace App\Repositories\Interfaces\PhoneBook\Contact;

use App\DTO\PhoneBook\Contact\ContactDto;
use App\Models\PhoneBook\Contact;
use Illuminate\Database\Eloquent\Collection;

interface ContactQueriesInterface
{
    /**
     * @description Получение всех контактов пользователя или всех избранных контактов пользователя
     *
     * @param int $userId
     * @param int $favorite
     * @param string $searchQuery
     * @return Collection
     */
    public function allContacts(int $userId, int $favorite, string $searchQuery): Collection;
    /**
     * @description Получение конкретного контакта по идентификатору контакта
     *
     * @param int $contactId
     * @return Contact
     */
    public function getContactById(int $contactId): Contact;
    /**
     * @description Удаление конкретного контакта по идентификатору контакта
     *
     * @param int $contactId
     * @return void
     */
    public function removeContact(int $contactId): void;
    /**
     * @description Создание нового контакта
     *
     * @param ContactDto $data
     * @param int $userId
     * @return Contact
     */
    public function createContact(ContactDto $data, int $userId): Contact;
    /**
     * @description Обновления существующего контакта по идентификатору
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
