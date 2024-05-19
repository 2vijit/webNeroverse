<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Works;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class WorkController extends Controller
{
    public function show()
    {
        return view('Backend.work.index');
    }

    public function list()
    {
        $works = Works::all();
        return datatables()->of($works)
            ->addColumn('status', function (Works $status) {
                if ($status->status == 'active') {
                    return "<span class='btn btn-success'>Active</span>";
                } elseif ($status->status == 'inactive') {
                    return "<label class='btn btn-danger'>Inactive</label>";
                }
            })
            ->rawColumns(['status'])
            ->setRowAttr([
                'align' => 'center',
            ])->make(true);
    }

    public function create()
    {
        return view('Backend.work.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $work = new Works();
        $work->title = $request->title;
        $work->description = $request->description;
        $work->status = $request->status;
        $work->save();

        foreach ($request->service_title as $key => $services) {
            $service = new Service();
            $service->title = $services;
            $service->description = $request->service_description[$key];
            $service->status = $request->service_status[$key];
            $service->deptId = $work->id;
            if ($request->hasFile('service_image')) {
                // Assuming you have multiple images for each food item
                $serviceImages = $request->file('service_image');
                $serviceImage = $serviceImages[$key] ?? null;
                if ($serviceImage) {
                    $images = $request->file('service_image');
                    $originalName = $images[$key]->getClientOriginalName();
                    $uniqueImageName = $request->service_title[$key] . rand(1000, 9999) . $originalName;
                    $image = Image::make($images[$key]);
                    $image->save(public_path() . '/service/' . $uniqueImageName);
                    $service->image = $uniqueImageName;
                }
            }
            $service->save();
        }
        Session::flash('success', 'Department Created Successfully');
        return redirect()->route('department.show');
    }


    public function edit($id)
    {
        $works = Works::where('id', $id)->first();
        $service = Service::where('deptId', $works->id)->get();
        // dd($service);
        return view('Backend.work.edit', compact('works', 'service'));
    }

    public function update(Request $request)
    {
        $works = Works::where('id', $request->id)->first();
        $works->title = $request->title;
        $works->description = $request->description;
        $works->status = $request->status;
        $works->save();

        if (isset($request->service_id)) {
            foreach ($request->service_id as $key => $i_id) {
                $service = Service::find($i_id);
                if ($service) {
                    $service->title = $request->service_title[$key];
                    $service->description = $request->service_description[$key];
                    $service->status = $request->service_status[$key];
                    if ($request->hasFile('service_image')) {
                        // Assuming you have multiple images for each food item
                        $serviceImages = $request->file('service_image');
                        $serviceImage = $serviceImages[$key] ?? null;
                        if ($serviceImage) {
                            $images = $request->file('service_image');
                            $originalName = $images[$key]->getClientOriginalName();
                            $uniqueImageName = $request->service_title[$key] . rand(1000, 9999) . $originalName;
                            $image = Image::make($images[$key]);
                            $image->save(public_path() . '/service/' . $uniqueImageName);
                            $serviceImage->image = $uniqueImageName;
                        }
                    }
                    $service->save();
                }
            }
        }

        if (!empty($request->extra_service_title)) {
            foreach ($request->extra_service_title as $key => $f_title) {
                $extra_service = new Service();
                $extra_service->title = $f_title;
                $extra_service->description = $request->extra_service_description[$key];
                $extra_service->status = $request->extra_service_status[$key];

                if ($request->hasFile('extra_service_image')) {
                    $serviceImages = $request->file('extra_service_image');
                    $serviceImage = $serviceImages[$key] ?? null;
                    if ($serviceImage) {
                        $images = $request->file('extra_service_image');
                        $originalName = $images[$key]->getClientOriginalName();
                        $uniqueImageName = $request->extra_service_title[$key] . rand(1000, 9999) . $originalName;
                        $image = Image::make($images[$key]);
                        $image->save(public_path() . '/service/' . $uniqueImageName);
                        $extra_service->image = $uniqueImageName;
                    }
                }
                $extra_service->deptId = $works->id;
                $extra_service->save();
            }
        }

        Session::flash('success', 'Works Updated Successfully');
        return redirect()->route('department.show');
    }

    public function delete(Request $request)
    {
        $works = Works::find($request->id);
        if (!$works) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        $works->delete();
        return response()->json();
    }
}
