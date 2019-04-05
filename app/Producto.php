<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
  use SoftDeletes;
    protected $dates=['deleted_at'];
    protected $table='productos';
    protected $fillable=[
      'name','descripcion'
    ];
}
