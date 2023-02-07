<?php

namespace App\Repositories\PhoneBook\Contact;

use App\DTO\PhoneBook\Contact\ContactDto;
use App\Models\PhoneBook\Contact;
use App\Repositories\Interfaces\PhoneBook\Contact\ContactQueriesInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ContactQueries implements ContactQueriesInterface
{
    /**
     * @description Получение всех контактов пользователя
     *
     * @param int $userId
     * @param int $favorite
     * @param string $searchQuery
     * @return Collection
     */
    public function allContacts(int $userId, int $favorite, string $searchQuery): Collection
    {
        $contacts = Contact::whereHas('user', function ($query) use ($userId){
            $query->where('users.id', $userId);
        });
        if(!empty($searchQuery)) $contacts = $contacts->where(function($query) use($searchQuery){
            $query->where(DB::raw(" CONCAT(`last_name`, ' ' ,`first_name`, ' ', `second_name`) "), 'like', '%'.$searchQuery.'%')
                ->orWhereHas('numbers', function($q) use($searchQuery){
                    $q->where('number', 'like', '%'.$searchQuery.'%');
                });
        });
        if($favorite == 1) $contacts = $contacts->where('favorite', $favorite);
        return $contacts->orderBy('last_name', 'ASC')->get();
    }

    /**
     * @description Получение конкретного контакта по идентификатору контакта
     *
     * @param int $contactId
     * @return Contact
     */
    public function getContactById(int $contactId): Contact
    {
        return Contact::findOrFail($contactId);
    }
    /**
     * @description Удаление конкретного контакта по идентификатору контакта
     *
     * @param int $contactId
     * @return void
     */
    public function removeContact(int $contactId): void
    {
        Contact::where('id', $contactId)->delete();
    }
    /**
     * @description Создание нового контакта
     *
     * @param ContactDto $data
     * @param int $userId
     * @return Contact
     */
    public function createContact(ContactDto $data, int $userId): Contact
    {
        return Contact::create([
            'first_name' => $data->firstName,
            'second_name' => $data->secondName,
            'last_name' => $data->lastName,
            'user_id' => $userId,
        ]);
    }
    /**
     * @description Обновления существующего контакта по идентификатору
     *
     * @param ContactDto $data
     * @param int $contactId
     * @return void
     */
    public function updateContact(ContactDto $data, int $contactId): void
    {
        Contact::where('id', $contactId)->update([
            'first_name' => $data->firstName,
            'second_name' => $data->secondName,
            'last_name' => $data->lastName,
        ]);
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
        Contact::where('id', $contactId)->update(['favorite' => !$favorite]);
    }
}
