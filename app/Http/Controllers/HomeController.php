<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LatestNews;
use App\Models\Package;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Team;
use App\Models\Works;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.pages.index');
    }

    public function about()
    {
        $document = Setting::query()->first();
        return view('frontend.pages.about', compact('document'));
    }

    public function service()
    {
        return view('frontend.pages.service');
    }

    public function casestudy()
    {
        return view('frontend.pages.casestudy');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    // public function page($pageId)
    // {
    //     $page = Page::query()->where('pageId', $pageId)->first();
    //     return view('pages.page', compact('page'));
    // }



}
