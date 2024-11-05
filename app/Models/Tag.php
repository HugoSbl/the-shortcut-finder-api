<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    private $fillable = ['name'];
    public function shortcuts()
    {
        return $this->belongsToMany(Shortcut::class);
    }
}
