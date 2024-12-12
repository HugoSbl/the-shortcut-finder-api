<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description'];

    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }
    public function icon ()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
