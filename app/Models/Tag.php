<?php
// commentaire: Modèle Tag
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //Relation polymorphique avec taggables
    public function shortcuts()
    {
        return $this->morphedByMany(Shortcut::class, 'taggable');
    }

    //On pourrait avoir d'autres morphs (ex: propositions taggables)
}
