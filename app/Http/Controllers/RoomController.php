<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomFeature;
use App\Models\RoomImage;
use App\Models\RoomService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    public function show()
    {
        return view('room.index');
    }

    public function list()
    {
        $rooms = Room::all();

        return datatables()->of($rooms)
            ->addColumn('image', function ($image) {
                if (isset($image->image)) {
                    return '<img src="' . url('public/roomImage/' . $image->image) . '" border="0" class="img-rounded" width="50px" align="center"/>';
                }
            })
            ->addColumn('images', function ($image) {
                $allImg = '';
                foreach ($image->images as $img) {
                    if (isset($img->image)) {
                        $allImg .= '<img src="' . url('public/roomImage/' . $img->image) . '" border="0" class="img-rounded" width="50px" align="center"/>';
                    }
                }
                return $allImg;
            })
            ->addColumn('status', function (Room $status) {
                if ($status->status == 'active') {
                    return "<span class='btn btn-success'>Active</span>";
                } elseif ($status->status == 'inactive') {
                    return "<label class='btn btn-danger'>Inactive</label>";
                }
            })
            ->rawColumns(['status', 'roomIcon', 'image', 'images'])
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

        $room = new Room();
        $room->name = $request->name;
        $room->view = $request->view;
        $room->price = $request->price;
        $room->discount_price = $request->discount_price;
        $room->size = $request->size;
        $room->capacity = $request->capacity;
        $room->bed = $request->bed;
        $room->bath = $request->bath;
        $room->detail = $request->detail;
        $room->service = $request->service;
        $room->status = $request->status;
        $room->discount_type = $request->discount_type;

        if ($request->hasFile('image')) {
            $originalName = $request->image->getClientOriginalName();

            $image = Image::make($request->image);
            $image->resize(1280, 853);

            // Save the image using the original filename
            $image->save(public_path() . '/roomImage/' . $originalName);

            $room->image = $originalName;
            $room->save();
        }

        foreach ($request->images as $roomImage) {
            if ($request->hasFile('images')) {
                $originalName = $roomImage->getClientOriginalName();
                $uniqueImageName = $request->name . rand(1000, 9999) . $originalName;
                $image = Image::make($roomImage);
                $image->resize(1280, 853);
                $image->save(public_path() . '/roomImage/' . $uniqueImageName);
                $roomImage = new RoomImage();
                $roomImage->fkRoomId = $room->id;
                $roomImage->image = $uniqueImageName;
                $roomImage->save();
            }
        }


        foreach ($request->fkServiceId as $key => $selectedServiceId) {
            $roomService = new RoomService();
            $roomService->fkRoomId = $room->id;
            $roomService->fkServiceId = $selectedServiceId;
            $roomService->save();
        }


        $room->save();

        Session::flash('success', 'Room Updated Successfully');
        return redirect()->route('room.show');
    }

    public function create()
    {
        $services = Service::where('status', 'active')->get();
        return view('room.create', compact('services'));
    }

    public function edit($id)
    {
        $room = Room::where('id', $id)->first();
        // $roomFeature=RoomFeature::query()->where('fkRoomId',$id)->get();
        $services = Service::where('status', 'active')->get();
        return view('room.edit', compact('room', 'services'));
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $room = Room::where('id', $request->id)->first();
        $room->name = $request->name;
        $room->view = $request->view;
        $room->price = $request->price;
        $room->discount_price = $request->discount_price;
        $room->size = $request->size;
        $room->capacity = $request->capacity;
        $room->bed = $request->bed;
        $room->bath = $request->bath;
        $room->detail = $request->detail;
        $room->service = $request->service;
        $room->status = $request->status;
        $room->discount_type = $request->discount_type;
        $room->save();

        if ($request->fkServiceId) {
            foreach ($request->fkServiceId as $packageService) {
                $pItem = RoomService::where('fkRoomId', $room->id)
                    ->where('fkServiceId', $packageService)
                    ->first();

                // Check if $pItem is not null before using count
                if ($pItem === null) {
                    $packageItem = new RoomService();
                    $packageItem->fkRoomId = $room->id;
                    $packageItem->fkServiceId = $packageService;
                    $packageItem->save();
                }
            }
        }


        if (!$request->fkServiceId) {
            RoomService::where('fkRoomId', $room->id)->delete();
        }


        if ($request->hasFile('image')) {
            $file_path_image = public_path() . '/roomImage/' . $room->image;
            File::delete($file_path_image);
            $originalName = $request->image->getClientOriginalName();
            $image = Image::make($request->image);
            $image->resize(1280, 853);
            // Save the image using the original filename
            $image->save(public_path() . '/roomImage/' . $originalName);
            $room->image = $originalName;
            $room->save();
        }

        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $originalName = $img->getClientOriginalName();
                $uniqueImageName = $request->name . rand(1000, 9999) . $originalName;
                $image = Image::make($img);
                $image->resize(1280, 853);
                $image->save(public_path() . '/roomImage/' . $uniqueImageName);
                $roomImage = new RoomImage();
                $roomImage->fkRoomId = $room->id;
                $roomImage->image = $uniqueImageName;
                $roomImage->save();
            }
        }


        // if (isset($request->feature_id)) {
        //     foreach ($request->feature_id as $key => $i_id) {
        //         $feature = RoomFeature::find($i_id);        
        //         if ($feature) 
        //         {
        //             $feature->room_feature_title = $request->room_feature_title[$key];
        //             $feature->room_feature_description = $request->room_feature_description[$key];
        //             $feature->room_content = $request->room_content[$key];                 
        //             $feature->save();
        //         }
        //     }
        // }

        Session::flash('success', 'Room Updated Successfully');
        return redirect()->route('room.show');
    }

    public function delete(Request $request)
    {
        $room = Room::where('id', $request->id)->first();
        $file_path_image = public_path() . '/roomImage/' . $room->image;
        File::delete($file_path_image);
        $room->delete();

        return response()->json();
    }
}
