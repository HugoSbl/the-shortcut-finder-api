<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = ['name', 'description'];

    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }
    public function icon ()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
