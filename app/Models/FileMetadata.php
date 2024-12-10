<?php
// commentaire: Modèle FileMetadata
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMetadata extends Model
{
    use HasFactory;

    protected $fillable = ['shortcut_id','file_size','mime_type','checksum'];

    public function shortcut()
    {
        return $this->belongsTo(Shortcut::class);
    }
}
