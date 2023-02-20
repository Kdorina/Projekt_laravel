<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class File extends Model
{
    public function users(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;
    protected $fillable =[
        'description',
        'image',
        'user_id',
    ];
    public $timestamps = false;
}
