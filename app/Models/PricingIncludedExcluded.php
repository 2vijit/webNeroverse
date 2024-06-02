<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingIncludedExcluded extends Model
{
    use HasFactory;
    protected $table = 'pricing_included_excluded';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'description', 'type', 'pricingId',
    ];
}
