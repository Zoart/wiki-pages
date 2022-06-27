<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkTable extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $casts = [
        'article_atom_text' => 'array'
    ];
}
