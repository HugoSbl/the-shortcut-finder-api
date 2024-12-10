<?php
// commentaire: Modèle ShortcutStorage
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortcutStorage extends Model
{
    use HasFactory;

    protected $fillable = ['shortcut_id','storage_type','storage_url'];

    // commentaire: Relation avec shortcut
    public function shortcut()
    {
        return $this->belongsTo(Shortcut::class);
    }
}
