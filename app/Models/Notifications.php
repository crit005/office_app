<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class Notifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'description',
        'page',
        'type',
        'download_link',
        'batch_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function batch()
    {
        return Bus::findBatch($this->batch_id);
    }
}
