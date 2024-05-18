<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Traits\ImageTrait;

class GalleryController extends Controller
{
    use ImageTrait;
    public function show()
    {
        return view('gallery.index');
    }

    public function list()
    {
        $gallerys = Gallery::all();

        return datatables()->of($gallerys)
            ->addColumn('image', function ($image) {
                if (isset($image->image)) {
                    return '<img src="' . url($image->image) . '" border="0" class="img-rounded" width="50px" align="center"/>';
                }
            })
            ->addColumn('status', function (Gallery $status) {
                if ($status->status == 'active') {
                    return "<span class='btn btn-success'>Active</span>";
                } elseif ($status->status == 'inactive') {
                    return "<label class='btn btn-danger'>Inactive</label>";
                }
            })
            ->rawColumns(['status', 'image'])
            ->setRowAttr([
                'align' => 'center',
            ])->make(true);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'nullable',
            'status' => 'required'
        ]);

        // if($request->type == 1)
        // {
        //   $featureImageLocation = $this->save_image('galleryImage', $validated['image'], 300, 200);
        // }

        // if($request->type == 2)
        // {
        //   $featureImageLocation = $this->save_image('galleryImage', $validated['image'], 500, 200);
        // }

        // if($request->type == 3)
        // {
        $featureImageLocation = $this->save_image('galleryImage', $validated['image']);
        // }

        $gallery = Gallery::query()->create([
            'name' => $validated['name'],
            'status' => $validated['status'],
            'image' => $featureImageLocation,
        ]);

        foreach ($request->gallery_images as $roomImage) {
            if ($request->hasFile('gallery_images')) {
                $originalName = $roomImage->getClientOriginalName();
                $uniqueImageName = $request->name . rand(1000, 9999) . $originalName;
                $image = Image::make($roomImage);
                $image->resize(1280, 853);
                $image->save(public_path() . '/galleryImage/' . $uniqueImageName);
                $roomImage = new GalleryImages();
                $roomImage->galleryId = $gallery->id;
                $roomImage->gallery_images = $uniqueImageName;
                $roomImage->save();
            }
        }

        Session::flash('success', 'Gallery Updated Successfully');
        return redirect()->route('gallery.show');
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function edit($id)
    {
        $gallery = Gallery::where('id', $id)->first();
        $galleryImages = GalleryImages::query()->where('galleryId', $id)->get();
        return view('gallery.edit', compact('gallery', 'galleryImages'));
    }

    public function update(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'nullable|max:255',

            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'nullable'
        ]);

        // $gallery = Gallery::where('id', $request->id)->first();
        // $gallery->name = $request->name;
        // $gallery->type = $request->type;
        // $gallery->status = $request->status;
        // $gallery->save();

        // if ($request->hasFile('image')) {
        //     $file_path_image = public_path().'/galleryImage/'.$gallery->image;
        //     File::delete($file_path_image);
        //     $originalName = $request->image->getClientOriginalName();
        //     $uniqueImageName = $request->name.rand(1000,9999).$originalName;
        //     $image = Image::make($request->image);
        //     $image->save(public_path().'/galleryImage/'.$uniqueImageName);
        //     $gallery->image = $uniqueImageName;
        //     $gallery->save();
        // }

        $gallery = Gallery::query()->where('id', $request->id)->first();
        if (!empty($gallery)) {

            if (empty($validated['image'])) {
                $imageLink = $gallery->image;
            } else {
                $this->deleteImage($gallery->image);
                $imageLink = $this->save_image('galleryImage', $validated['image']);
            }

            $gallery->update([
                'name' => $validated['name'],

                'status' => $validated['status'],
                'image' => $imageLink,
            ]);
        }


        if ($request->hasFile('g_image')) {
            foreach ($request->g_image as $img) {
                $originalName = $img->getClientOriginalName();
                $uniqueImageName = $request->name . rand(1000, 9999) . $originalName;
                $image = Image::make($img);
                $image->save(public_path() . '/galleryImage/' . $uniqueImageName);
                $roomImage = new GalleryImages();
                $roomImage->galleryId = $gallery->id;
                $roomImage->gallery_images = $uniqueImageName;
                $roomImage->save();
            }
        }

        Session::flash('success', 'Gallery Updated Successfully');
        return redirect()->route('gallery.show');
    }

    public function delete(Request $request)
    {
        $gallery = Gallery::where('id', $request->id)->first();
        $file_path_image = public_path() . '/galleryImage/' . $gallery->image;
        File::delete($file_path_image);
        $gallery->delete();

        return response()->json();
    }

    public function deleteGalleryImage(Request $request)
    {
        $gallery = GalleryImages::find($request->id);

        if (!$gallery) {
            return response()->json(['error' => 'Food not found'], 404);
        }

        // Delete the food image
        $file_path_image = public_path() . '/galleryImage/' . $gallery->gallery_images;
        File::delete($file_path_image);

        // Delete the 'food' record
        $gallery->delete();

        return response()->json();
    }
}
