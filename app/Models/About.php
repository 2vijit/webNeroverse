<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $table ='about';
    protected $primaryKey='id';
    public $timestamps = false;

    protected $fillable = [
        'background_image', 'why_choose_us_text', 'best_price_guaranty_text', 'quick_booking_text', 'about_title', 'about_content','about_homepage_image','about_home_title','about_home_content','customer_care_text',
    ];
}
