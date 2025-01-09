<?php

namespace App\Repositories\repositoryImpl;

use App\Models\Car;
use App\Models\Image;
use App\Repositories\IRepository;
use PhpParser\Node\Stmt\ElseIf_;

class CarRepositoryImpl implements IRepository
{
  protected $car;

  public function __construct(Car $car)
  {
    $this->car = $car;
  }

  // Get all cars
  public function getAll($request)
  {
    $sortBy = 'id';
    $typeOfSort = 'ASC';
    $search = '';
    if ($request->has('sortBy')) {
      if (in_array($request->sortBy, ['type', 'price_per_day', 'availability_status'])) {
        $sortBy = $request->sortBy;
        $typeOfSort = $request->typeOfSort ? $request->typeOfSort : $typeOfSort;
      }
    }
    if ($request->has('search') && !empty($request->search)) {
      $search = $request->search;
      $carReturned = $this->car->with(['image' => function ($query) {
        $query->select('imageable_id', 'path');
      }])
        ->where('name', 'LIKE', "%{$search}%")
        ->orderBy($sortBy, $typeOfSort)
        ->get();

      if ($carReturned->isEmpty()) {
        return response()->json(['error' => 'Car Not Found'], 401);
      } else {
        return response()->json($carReturned);
      }
    }
    return $this->car->with(['image' => function ($query) {
      $query->select('imageable_id', 'path');
    }])->orderby($sortBy, $typeOfSort)->get();
  }

  public function findById($id)
  {
    try {
      $car = $this->car->with(['image' => function ($query) {
        $query->select('imageable_id', 'path');
      }])->find($id);

      if ($car) {
        return response()->json($car, 200);
      } else {
        return response()->json(['error' => 'Car Not Found'], 404);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'An error occurred while fetching the car details'], 500);
    }
  }
  public function getAvailableCars()
  {
    return $this->car->where('availability_status', 1)->get();
  }

  public function createCarImage($img_name, $car)
  {
    $car->image()->create([
      'path' => 'images/' . $img_name
    ]);
  }
  public function create(array $data)
  {

    return $this->car->create($data);
  }

  // Update an existing car
  public function update($id, array $data)
  {
    $car = $this->car->find($id);
    if ($car) {
      $car->update($data);
      return $car;
    }
    return null;
  }

  // Delete a car
  public function delete($id)
  {
    $car = $this->car->find($id);
    if ($car) {
      $car->delete();
      return true;
    }
    return false;
  }
}
