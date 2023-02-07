<?php

namespace App\Http\Controllers\PhoneBook;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PhoneBookController extends Controller
{

    /**
     * @description Отображение основного списка контактов
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard');
    }

    /**
     * @description Отображение страницы для создания контакта
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('PhoneBook/Contact/Forms/CreateForm');
    }

    /**
     * @description Отображение формы редактирования контакта
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        return Inertia::render('PhoneBook/Contact/Forms/UpdateForm', [
            'contactId' => $id
        ]);
    }

    /**
     * @description Отображение конкретного контакта
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {

        return Inertia::render('PhoneBook/Contact/Contact', [
            'contactId' => $id
        ]);
    }

    /**
     * @description Отображение списка  избранных контактов
     *
     * @return Response
     */
    public function favorite(): Response
    {
        return Inertia::render('PhoneBook/Favorite');
    }
}
