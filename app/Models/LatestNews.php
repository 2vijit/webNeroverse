<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestNews extends Model
{
    use HasFactory;
    protected $table = 'latestnews';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title', 'description', 'image', 'page_link', 'status',
    ];
}
