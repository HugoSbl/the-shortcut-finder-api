<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class App extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','appable_id','appable_type'];

    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }
    public function icon ()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
