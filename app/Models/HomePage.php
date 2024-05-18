<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;
    protected $table ='homepage_contents';
    protected $primaryKey='id';
    public $timestamps = false;

    protected $fillable = [
        'bannerTitle', 'bannerTitleBangla', 'bannerLine1', 'bannerLine1Bangla', 'quality', 'qualityBangla', 'peoples', 'peoplesBangla', 'years', 'yearsBangla', 'smiles', 'smilesBangla', 'hireProsImage'
    ];
}
