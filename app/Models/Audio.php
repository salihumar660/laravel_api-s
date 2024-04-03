<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'audio_file',
    ];

    //Relation with users
   public function user()
   {
    return $this->belongsTo(User::class);
   }
}