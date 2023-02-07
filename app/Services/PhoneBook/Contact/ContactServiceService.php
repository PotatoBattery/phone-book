<?php

namespace App\Services\PhoneBook\Contact;

use App\DTO\PhoneBook\Contact\ContactDto;
use App\Models\PhoneBook\Contact;
use App\Repositories\Interfaces\PhoneBook\Contact\ContactQueriesInterface;
use App\Services\Interfaces\PhoneBook\Contact\ContactServiceInterface;
use App\Services\Interfaces\PhoneBook\Number\NumberServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactServiceService implements ContactServiceInterface
{
    private ContactQueriesInterface $contactQueries;
    private NumberServiceInterface $numberService;

    public function __construct(ContactQueriesInterface $contactQueries, NumberServiceInterface $numberService)
    {
        $this->contactQueries = $contactQueries;
        $this->numberService = $numberService;
    }
    /**
     * @description Метод для получения всех контактов пользователя или всех избранных контактов пользователя
     *
     * @param int $userId
     * @param int $favorite
     * @param string $searchQuery
     * @return Collection
     */
    public function getContacts(int $userId, int $favorite, string $searchQuery): Collection
    {
        return $this->contactQueries->allContacts($userId, $favorite, $searchQuery);
    }

    /**
     * @description Метод для удаления контакта
     *
     * @param int $contactId
     * @return void
     */
    public function removeContact(int $contactId): void
    {
        $this->contactQueries->removeContact($contactId);
    }
    /**
     * @description Метод для получения контакта по идентификатору
     *
     * @param int $id
     * @return Contact
     */
    public function getContactById(int $id): Contact
    {
        return $this->contactQueries->getContactById($id);
    }
    /**
     * @description Метод для создания контакта
     *
     * @param ContactDto $data
     * @param int $userId
     * @return Contact
     */
    public function createContact(ContactDto $data, int $userId): Contact
    {
        $contact = $this->contactQueries->createContact($data, $userId);
        $this->numberService->createNumbers($data->numbers, $contact->id);
        return $contact;
    }
    /**
     * @description Метод для обновления контакта
     *
     * @param ContactDto $data
     * @param int $contactId
     * @return void
     */
    public function updateContact(ContactDto $data, int $contactId): void
    {
        $this->contactQueries->updateContact($data, $contactId);
        foreach ($data->numbers as $number)
        {
            if($number->id != null){
                $this->numberService->updateNumber($number);
            }else{
                $this->numberService->createNumber($number, $contactId);
            }
        }
    }

    /**
     * @description Добавление контакта в избранное или удаление его из этого списка
     *
     * @param int $favorite
     * @param int $contactId
     * @return void
     */
    public function changeFavoriteContact(int $favorite, int $contactId): void
    {
        $this->contactQueries->changeFavoriteContact($favorite, $contactId);
    }
}
