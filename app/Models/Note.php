<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Note extends Model
{
    use HasFactory;
    public function users(){
        return $this->belongsTo(User::class);
    }
    protected $fillable =[
        "note",
        'user_id',
    ];
}
