<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Bookmark extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title', 'url'];
}
