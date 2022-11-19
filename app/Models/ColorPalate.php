<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorPalate extends Model
{
    protected $fillable=[
        "palet_name",
        "bg_color",
        "text_color",
        "bw_color"
    ];
    use HasFactory;

    public function getInlineStyleSet()
    {
        return 'style=background:'.$this->bg_color.';color:'.$this->text_color.';';
    }
    public function getInlineStyleBw()
    {
        return 'style=background:'.$this->bg_color.';color:'.$this->bw_color.';';
    }
}
