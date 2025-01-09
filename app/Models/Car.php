<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    //

    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'price_per_day',
        'availability_status'
    ];
    public $timestamps = false;

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
