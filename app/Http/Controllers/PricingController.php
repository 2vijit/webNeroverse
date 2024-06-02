<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\PricingIncludedExcluded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PricingController extends Controller
{
    public function index()
    {
        return view('Backend.pricing.index');
    }

    public function list()
    {
        $pricing = Pricing::all();
        return datatables()->of($pricing)
            ->setRowAttr([
                'align' => 'center',
            ])->make(true);
    }

    public function create()
    {
        return view('Backend.pricing.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $pricing = new Pricing();
        $pricing->title = $request->title;
        $pricing->cost = $request->cost;
        $pricing->duration = $request->duration;
        $pricing->currency = $request->currency;
        $pricing->save();

        foreach ($request->type as $key => $services) {
            $pricing_included_excluded = new PricingIncludedExcluded();
            $pricing_included_excluded->type = $services;
            $pricing_included_excluded->description = $request->description[$key];
            $pricing_included_excluded->pricingId = $pricing->id;
            $pricing_included_excluded->save();
        }
        Session::flash('success', 'Pricing Created Successfully');
        return redirect()->route('pricing.show');
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
