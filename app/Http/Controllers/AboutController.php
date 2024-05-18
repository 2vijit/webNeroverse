<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\AboutFacility;
use App\Models\AboutImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;

class AboutController extends Controller
{
    use ImageTrait;
    public function index()
    {
        return view('about.index');
    }

    public function list()
    {
        $packages = About::all();
        return datatables()->of($packages)
            ->addColumn('background_image', function (About $packages) {
                if (isset($packages->background_image)) {
                    return '<img height="50px" width="50px" src="' . url($packages->background_image) . '" alt="">';
                }
                return '';
            })
            ->setRowAttr([
                'align' => 'center',
            ])
            ->rawColumns(['background_image'])
            ->make(true);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'why_choose_us_text' => 'required',
            'best_price_guaranty_text' => 'nullable',
            'quick_booking_text' => 'required',
            'about_title' => 'required',
            'about_content' => 'nullable',
            'background_image' => 'nullable',
            'description' => 'nullable',
            'title' => 'nullable',
            'about_image' => 'nullable',
        ]);

        $about = About::query()->create([
            'why_choose_us_text' => $validated['why_choose_us_text'],
            'best_price_guaranty_text' => $validated['best_price_guaranty_text'],
            'background_image' => $this->save_image('aboutImage', $validated['background_image']),
            'quick_booking_text' => $validated['quick_booking_text'],
            'about_title' => $validated['about_title'],
            'about_content' => $validated['about_content'],
        ]);

        if (isset($validated['about_image'])) {
            foreach ($validated['about_image'] as $key => $image) {
                $aboutImage = AboutImage::query()->create([
                    'fkAboutId' => $about->id,
                    'title' => $request->title[$key],
                    'image' => $this->save_image('aboutImage', $image),
                ]);
            }
        }


        foreach ($request->description as $key => $in_text) {
            $facilities = new AboutFacility();
            $facilities->title = $in_text;
            $facilities->fkAboutId = $about->id;
            $facilities->save();
        }

        Session::flash('success', 'About Created Successfully!');
        return redirect()->route('about.show');
    }

    public function create()
    {
        return view('about.create');
    }

    public function edit($id)
    {
        $about = About::where('id', $id)->first();
        $about_image = AboutImage::query()->where('fkAboutId', $about->id)->get();
        $about_facility = AboutFacility::query()->where('fkAboutId', $about->id)->get();
        return view('about.edit', compact('about', 'about_image', 'about_facility'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $this->validate($request, [
            'why_choose_us_text' => 'nullable',
            'best_price_guaranty_text' => 'nullable',
            'quick_booking_text' => 'nullable',
            'customer_care_text' => 'nullable',
            'about_title' => 'nullable',
            'about_content' => 'nullable',
            'background_image' => 'nullable',
            'description' => 'nullable',
            'title' => 'nullable',
            'about_image' => 'nullable',
            'about_multi_image' => 'nullable',
            'about_multi_title' => 'nullable',
            'about_homepage_image' => 'nullable',
            'about_home_title' => 'nullable',
            'about_home_content' => 'nullable',

        ]);

        $about = About::query()->where('id', $id)->first();
        if (!empty($about)) {
            if (empty($validated['background_image'])) {
                $imageLink = $about->background_image;
            } else {
                $this->deleteImage($about->background_image);
                $imageLink = $this->save_image('aboutImage', $validated['background_image']);
            }

            if (empty($validated['about_homepage_image'])) {
                $aboutImage = $about->about_homepage_image;
            } else {
                $this->deleteImage($about->about_homepage_image);
                $aboutImage = $this->save_image('aboutImage', $validated['about_homepage_image']);
            }

            $about->update([
                'why_choose_us_text' => $validated['why_choose_us_text'],
                'best_price_guaranty_text' => $validated['best_price_guaranty_text'],
                'quick_booking_text' => $validated['quick_booking_text'],
                'customer_care_text' => $validated['customer_care_text'],
                'about_title' => $validated['about_title'],
                'about_content' => $validated['about_content'],
                'background_image' => $imageLink,
                'about_homepage_image' => $aboutImage,
                'about_home_title' => $validated['about_home_title'],
                'about_home_content' => $validated['about_home_content'],
            ]);
        }

        if (isset($validated['about_image'])) {
            foreach ($validated['about_image'] as $key => $image) {
                $aboutImage = AboutImage::query()->create([
                    'fkAboutId' => $about->id,
                    'title' => $request->title[$key],
                    'image' => $this->save_image('aboutImage', $image),
                ]);
            }
        }


        $aboutImageIds = $request->input('image_id', []);
        foreach ($aboutImageIds as $key => $imageId) {
            $aboutImages = AboutImage::find($imageId);
            if (!empty($aboutImages)) {
                $validated = $request->validate([
                    'about_multi_title.' . $key => 'required',
                    'about_multi_image.' . $key => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if (empty($validated['about_multi_image'][$key])) {
                    $imageLink = $aboutImages->image;
                } else {
                    $this->deleteImage($aboutImages->image);
                    $imageLink = $this->save_image('aboutImage', $validated['about_multi_image'][$key]);
                }

                $aboutImages->update([
                    'title' => $validated['about_multi_title'][$key],
                    'image' => $imageLink,
                ]);
            }
        }

        foreach ($request->f_id as $key => $f_id) {
            $facility = AboutFacility::find($f_id);
            if ($facility) {
                $facility->title = $request->description[$key];
                $facility->save();
            }
        }
        if (!empty($request->facility_title)) {
            foreach ($request->facility_title as $key => $facility_title) {
                $facility = new AboutFacility();
                $facility->title = $facility_title;
                $facility->fkAboutId = $about->id;
                $facility->save();
            }
        }

        Session::flash('success', 'About Updated Successfully!');
        return redirect()->route('about.show');
    }


    public function delete(Request $request)
    {
        $service = Service::where('id', $request->id)->first();
        $file_path_image = public_path() . '/serviceImage/' . $service->image;
        $file_path_icon = public_path() . '/serviceIcon/' . $service->icon;
        File::delete($file_path_image);
        File::delete($file_path_icon);
        $service->delete();

        return response()->json();
    }
}
