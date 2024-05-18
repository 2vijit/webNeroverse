<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerImage;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    use ImageTrait;
    public function index()
    {
        return view('banner.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $banner = Banner::query()->get();
        return datatables()->of($banner)
            ->setRowAttr([
                'align' => 'center',
            ])
            ->make(true);
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'banner_title' => 'required',
            'banner_description' => 'required',
            'image' => 'required',
            'bannerLink' => 'required',
        ]);

        $banner = Banner::query()->create([
            'banner_title' => $validated['banner_title'],
            'banner_description' => $validated['banner_description'],
            'bannerLink' => $validated['bannerlink'],
        ]);

        if (isset($validated['image'])) {
            foreach ($validated['image'] as $image) {
                $bannerImage = BannerImage::query()->create([
                    'fkBannerId' => $banner->id,
                    'image' => $this->save_image('bannerImage', $image),
                ]);
            }
        }


        Session::flash('success', 'Banner Created Successfully!');
        return redirect()->route('banner.show');
    }

    public function edit($bannerId)
    {
        $banner = Banner::query()->where('id', $bannerId)->first();
        $bannerImage = BannerImage::query()->where('fkBannerId', $banner->id)->get();
        return view('banner.edit', compact('banner', 'bannerImage'));
    }

    public function update(Request $request, $bannerId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'banner_title' => 'required',
            'banner_description' => 'nullable',
            'banner_image' => 'nullable',
            'banner_multi_image' => 'nullable',
            'pageLink' => 'required',
        ]);

        $banner = Banner::query()->where('id', $bannerId)->first();
        if (!empty($banner)) {
            $banner->update([
                'banner_title' => $validated['banner_title'],
                'banner_description' => $validated['banner_description'],
                'pageLink' => $validated['pageLink'],
            ]);
        }

        if (isset($validated['banner_multi_image'])) {
            foreach ($validated['banner_multi_image'] as $key => $banner) {
                $bannerMultiImage = BannerImage::query()->create([
                    'fkBannerId' => $bannerId,
                    'image' => $this->save_image('bannerImage', $banner),
                    //                    'image' => $this->save_image('bannerImage', $banner,640,360),
                ]);
            }
        }

        $bannerImageId = $request->input('image_id', []);
        foreach ($bannerImageId as $key => $imageId) {
            $bannerImages = BannerImage::find($imageId);
            if (!empty($bannerImages)) {
                $validated = $request->validate([

                    'banner_image.' . $key => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if (empty($validated['banner_image'][$key])) {
                    $imageLink = $bannerImages->image;
                } else {
                    $this->deleteImage($bannerImages->image);
                    $imageLink = $this->save_image('bannerImage', $validated['banner_image'][$key]);
                    //                    $imageLink = $this->save_image('bannerImage', $validated['banner_image'][$key],);
                }

                $bannerImages->update([
                    'image' => $imageLink,
                ]);
            }
        }
        Session::flash('success', 'Banner Updated Successfully!');
        return redirect()->route('banner.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $banner = Banner::query()->where('bannerId', $request->bannerId)->first();
        if (!empty($banner)) {
            $banner->delete();
        }
        return response()->json();
    }
}
