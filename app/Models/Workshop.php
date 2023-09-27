<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = ['ime', 'opis', 'user_id', 'category_id'];
    use HasFactory;
}
