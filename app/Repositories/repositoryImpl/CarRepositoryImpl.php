<?php

namespace App\Repositories\repositoryImpl;

use App\Models\Car;
use App\Models\Image;
use App\Repositories\IRepository;

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
    // dd($request);
    if ($request->has('sortBy')) {
      if (!in_array($request->sortBy, ['type', 'price_per_day', 'availability_status'])) {
        $sortBy = 'id';
        dd($request);
      } else {
        $sortBy = $request->sortBy;
        $typeOfSort = $request->typeOfSort ? $request->typeOfSort : $typeOfSort;
        return $this->car->orderBy($sortBy, $typeOfSort)->get();
      }
    } else {
      return $this->car->with(['image' => function ($query) {
        $query->select('imageable_id', 'path');
      }])->get();
    }
  }

  // Get car by id
  public function findBySearch($search)
  {
    // Filter for car type , price range , availability status

    return $this->car->with('image')->where('name', 'LIKE', "%{$search}%")->get();
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
