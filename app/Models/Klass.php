<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'klass_id');
    }

//    public function klass()
//    {
//        return $this->hasMany(Section::class);
//    }

    public function klass()
    {
        return $this->belongsTo(Klass::class, 'klass_id');
    }
}
