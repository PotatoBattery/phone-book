<?php

namespace App\Services\Interfaces\PhoneBook\Number;

use App\DTO\PhoneBook\Number\NumberDto;

interface NumberServiceInterface
{
    /**
     * @description Функция для массового создания новых номеров
     *
     * @param array $data
     * @param int $contactId
     * @return void
     */
    public function createNumbers(array $data, int $contactId): void;

    /**
     * @description Удаление номера из базы
     *
     * @param int $numberId
     * @return void
     */
    public function deleteNumber(int $numberId): void;
    /**
     * @description Создание одного номера при обновлении контакта (для осздания номера, если его раньше не было)
     *
     * @param NumberDto $numberDto
     * @param int $contactId
     * @return void
     */
    public function createNumber(NumberDto $numberDto, int $contactId): void;

    /**
     * @description Обновление номера, если он был изменен при редактировании контакта
     *
     * @param NumberDto $numberDto
     * @return void
     */
    public function updateNumber(NumberDto $numberDto): void;
}
