<?php
// commentaire: Modèle Version
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    protected $fillable = ['shortcut_id','version_number','content'];

    public function shortcut()
    {
        return $this->belongsTo(Shortcut::class);
    }
}
