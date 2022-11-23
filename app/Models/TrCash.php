<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCash extends Model
{
    use HasFactory;

    protected $fillable = [
        'tr_date',
        'item_id',
        'other_name',
        'amount',
        'currency_id',
        'to_from_id',
        'month',
        'description',
        'created_by',
        'type',
        'status',
        'input_type',
        'tr_id',
        'logs',
        'updated_by'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function toFromCrrency()
    {
        return $this->belongsTo(Currency::class, 'to_from');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function toFromUser()
    {
        return $this->belongsTo(User::class, 'to_from_id');
    }

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function depatment()
    {
        return $this->belongsTo(Depatment::class, 'to_from_id');
    }

    public function getDescription()
    {
        if(strlen($this->description)<36){
            return $this->description;
        }
        return substr($this->description, 0, 35).'...';
    }
}
