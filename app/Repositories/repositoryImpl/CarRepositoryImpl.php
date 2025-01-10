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

    $query = $this->car::query();

    if (isset($request->search) && !empty($request->search)) {
      $query->where('name', 'LIKE', "%{$request->search}%");
    }
    if (isset($request->type) && !empty($request->type)) {
      $query->where('type', 'LIKE', "%{$request->type}%");
    }
    if (isset($request->availability_status) && trim($request->availability_status) != '') {
      $query->where('availability_status', $request->availability_status);
    }
    if (isset($request->price_per_day_from) && trim($request->price_per_day_from) != "") {
      $query->where('price_per_day', ">=", $request->price_per_day_from);
    }
    if (isset($request->price_per_day_to) && trim($request->price_per_day_to) != "") {
      $query->where('price_per_day', "<=", $request->price_per_day_to);
    }
    

    return $query->with(['image' => function ($query) {
      $query->select('imageable_id', 'path');
    }])->get();
  }
  //============================
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


  public function createCarImage($img_name, $car)
  {
    $car->image()->create([
      'path' => 'images/' . $img_name
    ]);
  }


  public function updateMaintainance($id, $request)
  {
    if (isset($request->maintainance)) {
      $this->car::where('id', $id)->update([
        'maintainance' => $request->maintainance
      ]);
    } else {
      return response()->json(['error' => 'Maintainance is required'], 422);
    }
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
