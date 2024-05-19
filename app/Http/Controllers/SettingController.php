<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $setting = Setting::first();
        return view('backend.settings.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'companyName' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'address' => 'required|string',
            'logo_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'logo_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $setting = new Setting();
        $setting->companyName = $request->companyName;
        $setting->companyNameBangla = $request->companyNameBangla;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->phoneBangla = $request->phoneBangla;
        $setting->address = $request->address;
        $setting->addressBangla = $request->addressBangla;
        $setting->logo_1_alt_tag = $request->logo_1_alt_tag;
        $setting->logo_2_alt_tag = $request->logo_2_alt_tag;
        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->linkedin = $request->linkedin;
        $setting->youtube = $request->youtube;
        $setting->youtube = $request->youtube;


        if ($request->hasFile('logo_1')) {
            $setting->logo_1 = $this->save_image('settingImage', $request->file('logo_1'));
        }

        if ($request->hasFile('logo_2')) {
            $setting->logo_2 = $this->save_image('settingImage', $request->file('logo_2'));
        }
        $setting->save();

        Session::flash('success', 'Settings Updated Successfully');
        return redirect()->route('setting.show');
    }

    public function create()
    {
        return view('backend.settings.create');
    }

    public function edit($id)
    {
        $setting = Setting::where('id', $id)->first();
        return view('backend.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        // dd($request->footer_image);
        $this->validate($request, [
            'companyName' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'address' => 'required|string',
            'logo_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'logo_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $setting = Setting::first();
        $setting->companyName = $request->companyName;
        $setting->email = $request->email;
        $setting->reserve_email = $request->reserve_email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->footer_text = $request->footer_text;
        $setting->dhaka_office_email = $request->dhaka_office_email;
        $setting->addressBangla = $request->addressBangla;
        $setting->logo_1_alt_tag = $request->logo_1_alt_tag;
        $setting->logo_2_alt_tag = $request->logo_2_alt_tag;
        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->linkedin = $request->linkedin;
        $setting->youtube = $request->youtube;
        $setting->our_best_text = $request->our_best_text;
        $setting->accomodation_text = $request->accomodation_text;
        $setting->contact_page_text = $request->contact_page_text;
        $setting->fax = $request->fax;
        $setting->google_map_link = $request->google_map_link;
        $setting->home_banner_small_text = $request->home_banner_small_text;
        $setting->home_banner_large_text = $request->home_banner_large_text;
        $setting->about_banner_text = $request->about_banner_text;
        $setting->service_banner_text = $request->service_banner_text;
        $setting->homepage_our_mission_large_text = $request->homepage_our_mission_large_text;
        $setting->homepage_our_mission_small_text = $request->homepage_our_mission_small_text;
        $setting->homepage_our_vision_large_text = $request->homepage_our_vision_large_text;
        $setting->homepage_our_vision_small_text = $request->homepage_our_vision_small_text;
        $setting->homepage_our_works_text = $request->homepage_our_works_text;
        if ($request->hasFile('homepage_our_mission_image')) {
            $setting->homepage_our_mission_image = $this->save_image('settingImage', $request->file('homepage_our_mission_image'));
        }

        if ($request->hasFile('homepage_our_vision_image')) {
            $setting->homepage_our_vision_image = $this->save_image('settingImage', $request->file('homepage_our_vision_image'));
        }



        if ($request->hasFile('logo_1')) {
            $setting->logo_1 = $this->save_image('settingImage', $request->file('logo_1'));
        }

        if ($request->hasFile('logo_2')) {
            $setting->logo_2 = $this->save_image('settingImage', $request->file('logo_2'));
        }

        if ($request->hasFile('our_best_image')) {
            $setting->our_best_image = $this->save_image('settingImage', $request->file('our_best_image'));
        }

        if ($request->hasFile('video_section_image')) {
            $setting->video_section_image = $this->save_image('settingImage', $request->file('video_section_image'));
        }

        if ($request->hasFile('footer_image')) {
            $setting->footer_image = $this->save_image('settingImage', $request->file('footer_image'));
        }

        if ($request->hasFile('room_page_background_image')) {
            $setting->room_page_background_image = $this->save_image('settingImage', $request->file('room_page_background_image'));
        }

        if ($request->hasFile('contact_page_bg_image')) {
            $setting->contact_page_bg_image = $this->save_image('settingImage', $request->file('contact_page_bg_image'));
        }

        if ($request->hasFile('restaurent_bg_image')) {
            $setting->restaurent_bg_image = $this->save_image('settingImage', $request->file('restaurent_bg_image'));
        }

        if ($request->hasFile('promotion_page_bg_image')) {
            $setting->promotion_page_bg_image = $this->save_image('settingImage', $request->file('promotion_page_bg_image'));
        }

        if ($request->hasFile('meta_logo')) {
            $setting->meta_logo = $this->save_image('settingImage', $request->file('meta_logo'));
        }

        if ($request->hasFile('account_page_bg_image')) {
            $setting->account_page_bg_image = $this->save_image('settingImage', $request->file('account_page_bg_image'));
        }

        if ($request->hasFile('sister_concern_logo')) {
            $setting->sister_concern_logo = $this->save_image('settingImage', $request->file('sister_concern_logo'));
        }

        $setting->save();

        Session::flash('success', 'Settings Updated Successfully');
        return redirect()->route('setting.show');
    }
}
