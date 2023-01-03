<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Verifications extends Model
{
    use HasFactory, Notifiable,HasApiTokens;
    protected $fillable = [
        'users_id',
        'desc',
        'value',
        
    ];
    public function users()
    {
        return $this->belongsTo(Users::class);
    }
}
