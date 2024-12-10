<?php
// Modèle ShortcutInteraction
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortcutInteraction extends Model
{
    use HasFactory;

    protected $fillable = ['shortcut_id','user_id','interaction_type'];

    public function shortcut()
    {
        return $this->belongsTo(Shortcut::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
