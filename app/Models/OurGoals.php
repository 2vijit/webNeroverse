<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurGoals extends Model
{
    use HasFactory;
    protected $table = 'our_goals';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'status',
    ];
}
