<?php

namespace App\Repositories\PhoneBook\Number;

use App\DTO\PhoneBook\Number\NumberDto;
use App\Models\PhoneBook\Number;
use App\Repositories\Interfaces\PhoneBook\Number\NumberQueriesInterface;

class NumberQueries implements NumberQueriesInterface
{
    /**
     * @description Функция создания номера
     *
     * @param NumberDto $dto
     * @param int $contactId
     * @return void
     */
    public function createNumber(NumberDto $dto, int $contactId): void
    {
        Number::create([
            'number' => $dto->number,
            'contact_id' => $contactId
        ]);
    }
    /**
     * @description Удаление номера из базы по идентификатору
     *
     * @param int $numberId
     * @return void
     */
    public function deleteNumber(int $numberId): void
    {
        Number::where('id', $numberId)->delete();
    }
    /**
     * @description Обновление номера по идентификатору
     *
     * @param NumberDto $dto
     * @return void
     */
    public function updateNumber(NumberDto $dto): void
    {
        Number::where('id', $dto->id)->where('number', '!=', $dto->number)->update(['number' => $dto->number]);
    }
}
