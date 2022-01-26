<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reunion extends Model
{
    use HasFactory;
    protected $table = "reuniones";
    public $incrementing = false;
    protected $keyType = "uuid";
    
    protected $guarded = [];
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
