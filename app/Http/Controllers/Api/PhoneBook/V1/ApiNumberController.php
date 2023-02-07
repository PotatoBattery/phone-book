<?php

namespace App\Http\Controllers\Api\PhoneBook\V1;

use App\Http\Controllers\Api\ApiController;
use App\Services\Interfaces\PhoneBook\Number\NumberServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ApiNumberController extends ApiController
{
    private NumberServiceInterface $numberService;

    public function __construct(NumberServiceInterface $numberService)
    {
        $this->numberService = $numberService;
    }

    /**
     * @description Удаление номера у контакта
     *
     * @param int $id
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *     path="/numbers/{id}",
     *     operationId="destroyNumber",
     *     tags={"Number"},
     *     summary="Удаление номер из БД",
     *     description="Удаляет запись номера из базы данных",
     *     @OA\Parameter(name="id", in="path", description="Идентификатор номера", required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example=1, value=1, summary="Идентификатор контакта"),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="message", type="string", example="Номер успешно удалён")
     *          )
     *     ),
     *      @OA\Response(
     *          response=404, description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="404"),
     *              @OA\Property(property="data", type="object", example="[error: 'Номер не найден'}]")
     *          )
     *     )
     * )
     *
     */
    public function destroy(int $id): JsonResponse
    {
        try{
            $this->numberService->deleteNumber($id);
        }catch (ModelNotFoundException $e){
            return response()->json([
                'error' => 'Номер не найден'
            ], 404);
        }
        return response()->json([
            'message' => 'Номер успешно удалён'
        ], 200);
    }
}
