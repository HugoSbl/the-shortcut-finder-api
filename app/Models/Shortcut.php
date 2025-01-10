<?php
// commentaire: Modèle Shortcut
// commentaire: Gère les shortcuts, liens avec user, app, category
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','short_description','complete_description','number_of_downloads',
        'number_of_views','likes','dislikes','app_id','category_id','user_id','is_archived','is_deleted'
    ];

    // Relation avec l'user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec l'app
    public function app()
    {
        return $this->belongsTo(App::class, 'app_id');
    }

    // Relation avec la category_of_shortcut
    public function category()
    {
        return $this->belongsTo(CategoryOfShortcut::class, 'category_id');
    }

    // Relation avec les versions
    public function versions()
    {
        return $this->hasMany(Version::class);
    }

    // Relation avec les interactions
    public function interactions()
    {
        return $this->hasMany(ShortcutInteraction::class);
    }

    // Relation avec file_metadata
    public function fileMetadata()
    {
        return $this->hasMany(FileMetadata::class);
    }

    public function ShortcutStorage()
    {
        return $this->hasMany(ShortcutStorage::class);
    }

    // Relation avec tags (via taggables) - polymorphisme non nécessaire car table pivot ?
    // Ici, on utilise une table pivot "category_shortcut" mais pour tags on a taggables :
    // Dans la base initiale, on a "taggables" polymorphique. Si on veut lier shortcut et tags via taggables, on utilise morphToMany :
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
