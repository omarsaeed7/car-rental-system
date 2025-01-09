<?php

namespace App\Services;

use App\Repositories\repositoryImpl\CarRepositoryImpl;

class CarService
{

 private $carRepoImpl;

 public function __construct(CarRepositoryImpl $carRepoImpl)
 {
  $this->carRepoImpl = $carRepoImpl;
 }

 public function getAllCars($request)
 {
  return $this->carRepoImpl->getAll($request);
 }
 public function getAvailableCars(){
  return $this->carRepoImpl->getAvailableCars();
 }

 public function getCarById($id)
 {
  return $this->carRepoImpl->findById($id);
 }

 public function createCarWithImage($imageName, $car)
 {
  $this->carRepoImpl->createCarImage($imageName, $car);
 }

 public function createCar($data)
 {
  return $this->carRepoImpl->create($data);
 }
}
