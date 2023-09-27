<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['ime', 'user_id'];


    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    use HasFactory;
}
