<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transactions extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $fillable = [
        'users_id',
        'debit',
        'credit',
        'saldo',
        'from',
        'dest',
        'desc',
        
    ];
    public function users()
    {
        return $this->belongsTo(Users::class);
    }
}
