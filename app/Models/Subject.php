<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Subject extends Model
{

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    use HasFactory;
    protected $fillable =[
        'subject',
        'grade',
        'user_id',
    ];
    public $timestamps = false;

  
}