<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'currency_id',
        'current_balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }    

}
