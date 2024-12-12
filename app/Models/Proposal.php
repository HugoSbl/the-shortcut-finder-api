<?php
// Modèle Proposition
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{

    protected $fillable = [
        'title','short_description','is_approved','is_rejected','is_resolved','likes','dislikes',
        'category_id','user_id','app_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryOfShortcut::class, 'category_id');
    }

    // Possibilité de tags si taggable sur propositions :
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
