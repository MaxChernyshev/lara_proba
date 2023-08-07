<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone_number',
        'section_id',
        'klass_id',
    ];

    public function klass()
    {
        return $this->belongsTo(Klass::class, 'klass_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
