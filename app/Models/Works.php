<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    use HasFactory;
    protected $table = 'works';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'status',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'deptId', 'id');
    }
}
