<?php
// commentaire: Modèle CategoryOfShortcut
// commentaire: Gère les catégories, liens avec shortcuts
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOfShortcut extends Model
{
    use HasFactory;

    protected $table = 'categories_of_shortcut';

    protected $fillable = ['title','description','parent_id','number_of_shortcuts_associated'];

    // commentaire: Relation avec les shortcuts
    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class, 'category_id');
    }

    // commentaire: Relation avec la catégorie parente
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // commentaire: Relation avec les sous-catégories
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
