<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Phone Book application API Documentation",
 *     description="Documentation for Phone Book Application API",
 *     @OA\Contact(
 *          name="Danila Frolov",
 *          email="danila-frolov-1996@mail.ru"
 *     ),
 *     @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @Oa\Server(
 *     url="/api/v1/phone-book/"
 * )
 */
class ApiController extends Controller
{

}
