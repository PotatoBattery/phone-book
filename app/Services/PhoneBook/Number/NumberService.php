<?php

namespace App\Services\PhoneBook\Number;

use App\DTO\PhoneBook\Number\NumberDto;
use App\Repositories\Interfaces\PhoneBook\Number\NumberQueriesInterface;
use App\Services\Interfaces\PhoneBook\Number\NumberServiceInterface;

class NumberService implements NumberServiceInterface
{
    private NumberQueriesInterface $numberQueries;

    public function __construct(NumberQueriesInterface $numberQueries)
    {
        $this->numberQueries = $numberQueries;
    }
    /**
     * @description Функция для массового создания новых номеров
     *
     * @param array $data
     * @param int $contactId
     * @return void
     */
    public function createNumbers(array $data, int $contactId): void
    {
        foreach ($data as $numberDto)
        {
            $this->numberQueries->createNumber($numberDto, $contactId);
        }
    }
    /**
     * @description Удаление номера из базы
     *
     * @param int $numberId
     * @return void
     */
    public function deleteNumber(int $numberId): void
    {
        $this->numberQueries->deleteNumber($numberId);
    }

    /**
     * @description Создание одного номера при обновлении контакта (для осздания номера, если его раньше не было)
     *
     * @param NumberDto $numberDto
     * @param int $contactId
     * @return void
     */
    public function createNumber(NumberDto $numberDto, int $contactId): void
    {
        $this->numberQueries->createNumber($numberDto, $contactId);
    }

    /**
     * @description Обновление номера, если он был изменен при редактировании контакта
     *
     * @param NumberDto $numberDto
     * @return void
     */
    public function updateNumber(NumberDto $numberDto): void
    {
        $this->numberQueries->updateNumber($numberDto);
    }
}
