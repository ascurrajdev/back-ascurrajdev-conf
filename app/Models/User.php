<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    protected $keyType = "uuid";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    public function reuniones(){
        return $this->hasMany(Reunion::class);
    }

    public function reunionesJoin(){
        return $this->hasMany(ReunionJoin::class);
    }

    protected static function booted(){
        static::creating(function($user){
            try{
                $user->id = (string) Str::uuid();
            }catch(Exception $e){
                abort(500,$e->getMessage());
            }
        });
    }
}
