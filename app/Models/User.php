<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Subject;
use App\Models\Note;
use App\Models\File;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function subject(){
        return $this->hasMany(Subject::class);
    }
    public function files(){
        return $this->hasMany(File::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function getId()
{
  return $this->id;
}
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buildingName',
        'name',
        'email',
        'date_of_birth',
        'gender',
        'password',
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
