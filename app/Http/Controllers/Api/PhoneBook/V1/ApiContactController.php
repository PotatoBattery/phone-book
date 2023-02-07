<?php

namespace App\Http\Controllers\Api\PhoneBook\V1;

use App\DTO\Factories\PhoneBook\Contact\ContactDtoFactory;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PhoneBook\Contact\ContactCreateRequest;
use App\Http\Requests\PhoneBook\Contact\ContactUpdateRequest;
use App\Http\Resources\PhoneBook\Contact\ContactCollection;
use App\Http\Resources\PhoneBook\Contact\ContactResource;
use App\Services\Interfaces\PhoneBook\Contact\ContactServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiContactController extends ApiController
{
    private ContactServiceInterface $service;

    public function __construct(ContactServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @description Просмотр списка контактов
     *
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/contacts",
     *     operationId="index",
     *     tags={"Contacts"},
     *     summary="Получение всех контактов",
     *     description="Получение списка всех контактов пользователя",
     *     @OA\Parameter(name="searchQuery", in="query", description="Поисковой запрос", required=false,
     *          @OA\Schema(type="String"),
     *          @OA\Examples(example="Фамилия", value="Фролов", summary="Фамилия контакта"),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="data", type="object", example="[{id: 1, firstName:'Иван', secondName:'Иванович', lastName:'Иванов', favorite: true, numbers:[{id:1, value:'81234567901'}]}]")
     *          )
     *     ),
     *     @OA\Response(
     *          response=204, description="No content",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="204"),
     *              @OA\Property(property="data", type="object", example="[]")
     *          )
     *     )
     * )
     *
     */
    public function index(Request $request): JsonResponse
    {
        $searchQuery = (string)$request->get('searchQuery');
        $userId = auth()->id();
        $contacts = $this->service->getContacts($userId, 0, $searchQuery);
        if(!empty($contacts->count())){
            return response()->json(new ContactCollection($contacts), 200);
        }else{
            return response()->json([], 204);
        }
    }

    /**
     * @description Просмотр списка избранных контактов
     *
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/favorite/contacts",
     *     operationId="indexFavorite",
     *     tags={"Contacts"},
     *     summary="Получение всех избранных контактов",
     *     description="Получение списка всех избранных контактов пользователя",
     *     @OA\Parameter(name="searchQuery", in="query", description="Поисковой запрос", required=false,
     *          @OA\Schema(type="String"),
     *          @OA\Examples(example="Фамилия", value="Фролов", summary="Фамилия контакта"),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="data", type="object", example="[{id: 1, firstName:'Иван', secondName:'Иванович', lastName:'Иванов', favorite: true, numbers:[{id:1, value:'81234567901'}]}]")
     *          )
     *     ),
     *     @OA\Response(
     *          response=204, description="No content",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="204"),
     *              @OA\Property(property="data", type="object", example="[]")
     *          )
     *     )
     * )
     *
     */
    public function indexFavorite(Request $request): JsonResponse
    {
        $searchQuery = (string)$request->get('searchQuery');
        $userId = auth()->id();
        $contacts = $this->service->getContacts($userId, 1, $searchQuery);
        if(!empty($contacts->count())){
            return response()->json(new ContactCollection($contacts), 200);
        }else{
            return response()->json([], 204);
        }
    }

    /**
     * @description Создание нового контакта
     *
     * @param ContactCreateRequest $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/contacts",
     *     operationId="store",
     *     tags={"Contacts"},
     *     summary="Запись контакта в БД",
     *     description="Добавляет новую запись контакта в базу данных",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"firstName", "lastName", "numbers"},
     *              @OA\Property(property="firstName", type="string", example="Иван"),
     *              @OA\Property(property="secondName", type="string", example="Иванович"),
     *              @OA\Property(property="lastName", type="string", example="Иванов"),
     *              @OA\Property(property="numbers", type="array", example="[{'value': '89152207686'}]",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="value", type="string")
     *                  )
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          response=201, description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="201"),
     *              @OA\Property(property="data", type="object", example="{id: 1, firstName:'Иван', secondName:'Иванович', lastName:'Иванов', favorite: false, numbers:[{id:1, value:'385905890348'}, {id:2, value:'48290348092834'}]}")
     *          )
     *     ),
     *     @OA\Response(
     *          response=422, description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="422"),
     *              @OA\Property(property="data", type="object", example="[{message: 'Ошибка SQL', error: 'Информация об ошибке'}]")
     *          )
     *     )
     * )
     *
     */
    public function store(ContactCreateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
//        dd(__METHOD__, $validatedData);
        $dto = ContactDtoFactory::fromArray($validatedData);
        $userId = auth()->id();
        try{
            $contact = $this->service->createContact($dto, $userId);
        }catch (QueryException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->errorInfo
            ], 422);
        }
        return response()->json(new ContactResource($contact), 201);
    }

    /**
     * @description Отображение конкретного контакта по идентификатору
     *
     * @param  int  $id
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/contacts/{id}",
     *     operationId="show",
     *     tags={"Contacts"},
     *     summary="Получение конкретного контакта",
     *     description="Получение конкретного контакта по идентификатору",
     *     @OA\Parameter(name="id", in="path", description="Идентификатор контакта", required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example=1, value=1, summary="Идентификатор контакта"),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="data", type="object", example="{id: 1, firstName:'Иван', secondName:'Иванович', lastName:'Иванов', favorite: true, numbers:[{id:1, value:'81234567901'}]}")
     *          )
     *     ),
     *     @OA\Response(
     *          response=404, description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="404"),
     *              @OA\Property(property="data", type="object", example="[error: 'No query results for model [App\\Models\\PhoneBook\\Contact] id модели'}]")
     *          )
     *     )
     * )
     *
     */
    public function show(int $id): JsonResponse
    {
        try{
            $contact = $this->service->getContactById($id);
        }catch (ModelNotFoundException $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }
        return response()->json(new ContactResource($contact), 200);

    }

    /**
     * @description Обновление конкретного контакта по идентификатору
     *
     * @param ContactUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    /**
     * @OA\Put(
     *     path="/contacts/{id}",
     *     operationId="update",
     *     tags={"Contacts"},
     *     summary="Обновление контакта в БД",
     *     description="Обновляет запись контакта в базе данных",
     *     @OA\Parameter(name="id", in="path", description="Идентификатор контакта", required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example=1, value=1, summary="Идентификатор контакта"),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"firstName", "lastName", "numbers"},
     *              @OA\Property(property="firstName", type="string", example="Иван"),
     *              @OA\Property(property="secondName", type="string", example="Иванович"),
     *              @OA\Property(property="lastName", type="string", example="Иванов"),
     *              @OA\Property(property="numbers", type="object", example="[{id: 1, value: '385905890348'}, {value: '48290348092834'}]"),
     *          )
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="20"),
     *              @OA\Property(property="data", type="object")
     *          )
     *     ),
     *     @OA\Response(
     *          response=422, description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="422"),
     *              @OA\Property(property="data", type="object", example="[{message: 'Ошибка SQL', error: 'Информация об ошибке'}]")
     *          )
     *     )
     * )
     *
     */
    public function update(ContactUpdateRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $dto = ContactDtoFactory::fromArray($validatedData);
        try{
            $this->service->updateContact($dto, $id);
        }catch (QueryException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->errorInfo
            ], 422);
        }
        return response()->json([
            'message' => 'Контакт успешно обновлён'
        ], 200);
    }

    /**
     * @description Удаление конкретного контакта по идентификатору
     *
     * @param  int  $id
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *     path="/contacts/{id}",
     *     operationId="destroy",
     *     tags={"Contacts"},
     *     summary="Удаление контакта из БД",
     *     description="Удаляет запись контакта из базы данных",
     *     @OA\Parameter(name="id", in="path", description="Идентификатор контакта", required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example=1, value=1, summary="Идентификатор контакта"),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="message", type="string", example="Контакт успешно удалён")
     *          )
     *     ),
     *      @OA\Response(
     *          response=404, description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="404"),
     *              @OA\Property(property="data", type="object", example="[error: 'Контакт не найден'}]")
     *          )
     *     )
     * )
     *
     */
    public function destroy(int $id): JsonResponse
    {
        try{
            $this->service->removeContact($id);
        }catch (ModelNotFoundException $e){
            return response()->json([
                'error' => 'Контакт не найден'
            ], 404);
        }
        return response()->json([
            'message' => 'Контакт успешно удалён'
        ], 200);
    }

    /**
     * @description Добавление контакта в избранное или удаление из избранного
     *
     * @param Request $request
     * @param int $contactId
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *     path="/contacts/favorite/{id}",
     *     operationId="favorite",
     *     tags={"Contacts"},
     *     summary="Добавление/удаление избранности контатка",
     *     description="Добавляет контакт в список избранных или удаляет его оттуда",
     *     @OA\Parameter(name="id", in="path", description="Идентификатор контакта", required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example=1, value=1, summary="Идентификатор контакта"),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"favorite"},
     *              @OA\Property(property="favorite", type="boolean", example=true),
     *          )
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="message", type="string", example="Избранность контакта успешно обновлена")
     *          )
     *     ),
     *     @OA\Response(
     *          response=422, description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="422"),
     *              @OA\Property(property="data", type="object", example="[{message: 'Ошибка SQL', error: 'Информация об ошибке'}]")
     *          )
     *     )
     * )
     *
     */
    public function favorite(Request $request, int $contactId): JsonResponse
    {
        $favorite = $request->favorite;
        try{
            $this->service->changeFavoriteContact($favorite, $contactId);
        }catch (QueryException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->errorInfo
            ], 422);
        }
        return response()->json([
            'message' => 'Избранность контакта успешно обновлена'
        ], 200);
    }
}
