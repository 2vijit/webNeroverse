<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table = 'team';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'designation', 'image', 'status',
    ];
}
