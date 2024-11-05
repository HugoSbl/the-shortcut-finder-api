<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
