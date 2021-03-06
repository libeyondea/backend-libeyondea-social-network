<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function getUrlAttribute()
    {
        return config('app.img_url') . '/' . $this->name;
    }
}
