<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function index()
    {
        $cars = Car::with('user')->get();
        return response()->json($cars);
    }

    public function store(StoreCarRequest $request)
    {
        return response()->json(['Success' => Car::create($request->validated())]);
    }

    public function show(Car $car)
    {
        return response()->json($car);
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        return response()->json(['Success' => $car->update($request->validated())]);
    }

    public function destroy(Car $car)
    {
        return response()->json(['Success' => $car->delete()]);
    }

    public function updateUser(Request $request)
    {
        $car = Car::whereId($request->car_id)->update(['user_id' => $request->user_id]);
        return response()->json($car);
    }
}
