<?php

namespace App\Repositories\Interfaces\PhoneBook\Number;

use App\DTO\PhoneBook\Number\NumberDto;
use App\Models\PhoneBook\Number;

interface NumberQueriesInterface
{
    /**
     * @description Функция создания номера
     *
     * @param NumberDto $dto
     * @param int $contactId
     *
     * @return void
     */
    public function createNumber(NumberDto $dto, int $contactId): void;
    /**
     * @description Удаление номера из базы по идентификатору
     *
     * @param int $numberId
     * @return void
     */
    public function deleteNumber(int $numberId): void;
    /**
     * @description Обновление номера по идентификатору
     *
     * @param NumberDto $dto
     * @return void
     */
    public function updateNumber(NumberDto $dto): void;
}
