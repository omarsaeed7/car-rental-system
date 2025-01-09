<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Client\ResponseSequence;

class CarController extends Controller
{
    private $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    // Get All Cars
    public function getCars(Request $request)
    {
        return response()->json($this->carService->getAllCars($request));
        
        // retrive the image only 
        // $cars = $this->carService->getAllCars();
        // return view('welcome', compact('cars'));
    }

    // Store New Car
    public function storeCar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'type' => 'required|string',
                'price_per_day' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'availability_status' => 'nullable|boolean',
                'image' => 'mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);
            if ($validator->fails()) {
                return Response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 400);
            }
            $car =  $this->carService->createCar($request->all());

            if ($request->hasFile('image')) {
                $img_name = uniqid() . time() . '.' . $request->image->getClientOriginalExtension();

                $request->image->move(public_path('images'), $img_name);

                $this->carService->createCarWithImage($img_name, $car);
            }
            return response()->json($car, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.', 'message' => $e->getMessage()], 500);
        }
    }

    // public function filterCars(){
    //     return 0;
    // }
    // Show Car By Search
    public function viewSingleCar($search)
    {
        if ($search && !empty($search)) {
            // $cars = Car::with('image')->where('name', 'LIKE', "%{$search}%")->get();
            $cars = $this->carService->getCarBySearch($search);
            return response()->json($cars);
        } else {
            return response()->json(['error' => 'Car Not Found'], 400);
        }
    }

    public function edit(string $id) {}

    public function updateCar(Request $request, string $id)
    {
        //
    }

    public function destroyCar(string $id)
    {
        //
    }
}