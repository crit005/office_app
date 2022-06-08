<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tr_date',
        'item_id',
        'item_name',
        'amount',
        'bk_amount',
        'balance',
        'user_balance',
        'currency_id',
        'to_from',
        'month',
        'description',
        'owner',
        'type',
        'status',
        'input_type',
        'tr_id',
        'uuid'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function toFromCrrency()
    {
        return $this->belongsTo(Currency::class, 'to_from');    
    }

    public function user()
    {
        return $this->belongsTo(User::class,'owner');
    }

    public function item()
    {
        return $this->belongsTo(Items::class,'item_id');
    }

    public function depatment()
    {
        return $this->belongsTo(Depatment::class,'to_from');
    }
}
