<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    public function show()
    {
        return view('package.index');
    }

    public function list()
    {
        $packages = Package::all();

        return datatables()->of($packages)
            ->addColumn('image', function ($image) {
                if (isset($image->image)) {
                    return '<img src="' . url('public/packageImage/' . $image->image) . '" border="0" class="img-rounded" width="50px" align="center"/>';
                }
            })
            ->addColumn('status', function (Package $status) {
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
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $package = new Package();
        $package->fkRoomId = $request->fkRoomId;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->package_description = $request->package_description;
        $package->status = $request->status;
        $package->image_type = $request->image_type;

        $package->save();

        // foreach($request->fkServiceId as $key => $packageService){
        //     $packageItem = new PackageItem();
        //     $packageItem->fkPackageId = $package->id;
        //     $packageItem->fkServiceId = $packageService[$key];
        //     $packageItem->save();
        // }

        if ($request->hasFile('image')) {
            $originalName = $request->image->getClientOriginalName();

            $image = Image::make($request->image);
            // $image->resize(1280, 853);

            // Save the image using the original filename
            $image->save(public_path() . '/packageImage/' . $originalName);
            $package->image = $originalName;
            $package->save();
        }

        Session::flash('success', 'Package Updated Successfully');
        return redirect()->route('package.show');
    }

    public function create()
    {
        $rooms = Room::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();
        return view('package.create', compact('rooms', 'services'));
    }

    public function edit($id)
    {
        $package = Package::where('id', $id)->first();
        $rooms = Room::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();
        return view('package.edit', compact('package', 'rooms', 'services'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $package = Package::where('id', $request->id)->first();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->fkRoomId = $request->fkRoomId;
        $package->package_description = $request->package_description;
        $package->status = $request->status;
        $package->image_type = $request->image_type;
        $package->save();

        // if($request->fkServiceId){
        //     foreach($request->fkServiceId as $key => $packageService){
        //         $pItem = PackageItem::where('fkPackageId', $package->id)->where('fkServiceId', $packageService[$key])->first();
        //         if(empty($pItem)){
        //             $packageItem = new PackageItem();
        //             $packageItem->fkPackageId = $package->id;
        //             $packageItem->fkServiceId = $packageService[$key];
        //             $packageItem->save();
        //         }
        //     }
        // }

        if (!$request->fkServiceId) {
            PackageItem::where('fkPackageId', $package->id)->delete();
        }

        // if ($request->hasFile('image')) {
        //     $file_path_image = public_path().'/packageImage/'.$package->image;
        //     File::delete($file_path_image);
        //     $originalName = $request->image->getClientOriginalName();
        //     $uniqueImageName = $request->name.rand(1000,9999).$originalName;
        //     $image = Image::make($request->image);
        //     $image->save(public_path().'/packageImage/'.$uniqueImageName);
        //     $package->image = $uniqueImageName;
        //     $package->save();
        // }

        if ($request->hasFile('image')) {
            $file_path_image = public_path() . '/packageImage/' . $package->image;
            File::delete($file_path_image);
            $originalName = $request->image->getClientOriginalName();
            $image = Image::make($request->image);
            $image->resize(1280, 853);
            // Save the image using the original filename
            $image->save(public_path() . '/packageImage/' . $originalName);
            $package->image = $originalName;
            $package->save();
        }

        Session::flash('success', 'Package Updated Successfully');
        return redirect()->route('package.show');
    }

    public function delete(Request $request)
    {
        $package = Package::where('id', $request->id)->first();
        $file_path_image = public_path() . '/packageImage/' . $package->image;
        File::delete($file_path_image);
        PackageItem::where('fkPackageId', $package->id)->delete();
        $package->delete();

        return response()->json();
    }
}
