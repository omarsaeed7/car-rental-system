<?php
namespace App\Repositories;

interface IRepository
{
    public function getAll($request);
    public function findBySearch($search);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}