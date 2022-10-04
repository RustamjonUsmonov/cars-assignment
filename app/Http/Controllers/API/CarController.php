<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description"
 * )
 */
class CarController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/cars",
     *      operationId="getCarsList",
     *      tags={"Cars"},
     *      summary="Get list of cars",
     *      description="Returns list of cars",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     )
     * )
     */
    public function index()
    {
        $cars = Car::with('user')->get();
        return response()->json($cars);
    }

    /**
     * @OA\Post(
     *      path="/api/cars",
     *      operationId="storeCar",
     *      tags={"Cars"},
     *      summary="Store new car",
     *      description="Returns project data",
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function store(StoreCarRequest $request)
    {
        return response()->json(['Success' => Car::create($request->validated())]);
    }

    /**
     * @OA\Get(
     ** path="/api/cars/{id}",
     *   tags={"Cars"},
     * summary="Get car information",
     * description="Returns car data",
     *   operationId="getCarById",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Car id",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not Found"
     *   )
     * )
     **/
    public function show(Car $car)
    {
        return response()->json($car);
    }

        /**
         * @OA\Put(
         *      path="/api/cars/{id}",
         *      operationId="updateCar",
         *      tags={"Cars"},
         *      summary="Update existing car",
         *      description="Returns updated car data",
         *      @OA\Parameter(
         *          name="id",
         *          description="Car id",
         *          required=true,
         *          in="path",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *   @OA\Response(
         *      response=200,
         *       description="Success"
         *   ),
         *   @OA\Response(
         *      response=400,
         *      description="Bad Request"
         *   ),
         *   @OA\Response(
         *      response=404,
         *      description="Not Found"
         *   )
         * )
         **/
    public function update(UpdateCarRequest $request, Car $car)
    {
        return response()->json(['Success' => $car->update($request->validated())]);
    }

    /**
     * @OA\Delete(
     *      path="/api/cars/{id}",
     *      operationId="deleteCar",
     *      tags={"Cars"},
     *      summary="Delete existing car",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Car id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Car $car)
    {
        return response()->json(['Success' => $car->delete()]);
    }

    /**
     * @OA\Put(
     *      path="/api/update-car-user",
     *      operationId="updateCarUser",
     *      tags={"Cars"},
     *      summary="Update car user",
     *      description="Returns car data",
     *  @OA\Parameter(
     *      name="car_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function updateCarUser(Request $request)
    {
        $car = Car::whereId($request->car_id)->update(['user_id' => $request->user_id]);
        return response()->json($car);
    }
}
