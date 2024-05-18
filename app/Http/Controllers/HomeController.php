<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\Room;
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
        // $totalRoom = Room::count();
        // $totalPackage = Package::count();
        // $totalReservation = Reservation::count();
        // $totalCustomer = Customer::count();
        return view('frontend.pages.index');
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function service()
    {
        return view('frontend.pages.service');
    }

    public function casestudy()
    {
        return view('frontend.pages.casestudy');
    }

    // public function page($pageId)
    // {
    //     $page = Page::query()->where('pageId', $pageId)->first();
    //     return view('pages.page', compact('page'));
    // }



}
