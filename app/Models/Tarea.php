<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    // app/Models/Tarea.php  (o Task.php)

    protected $fillable = [
    'titulo',
    'descripcion',
    'estado',
    'user_id',
];


public function user()
{
    return $this->belongsTo(User::class);
}

    use HasFactory;
}
