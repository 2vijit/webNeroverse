<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    use ImageTrait;
    public function show()
    {
        return view('Backend.service.index');
    }

    public function list()
    {
        $latestnews = Service::query()->get();
        return datatables()->of($latestnews)
            ->addColumn('image', function (Service $latestnews) {
                if (isset($latestnews->image)) {
                    return '<img height="50px" width="50px" src="' . url($latestnews->image) . '" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (Service $latestnews) {
                if ($latestnews->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align' => 'center',
            ])
            ->rawColumns(['image', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('Backend.service.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        $latestnews = Service::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $this->save_image('service', $validated['image']),
        ]);

        Session::flash('success', 'Service New Created Successfully!');
        return redirect()->route('service.show');
    }

    public function edit($id)
    {
        $latestnews = Service::where('id', $id)->first();
        return view('Backend.service.edit', compact('latestnews'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $this->validate($request, [
            'title' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable',
        ]);

        $latestnews = Service::query()->where('id', $id)->first();
        if (!empty($latestnews)) {
            if (empty($validated['image'])) {
                $imageLink = $latestnews->image;
            } else {
                $this->deleteImage($latestnews->image);
                $imageLink = $this->save_image('service', $validated['image']);
            }

            $latestnews->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'image' => $imageLink,
            ]);
        }

        Session::flash('success', 'Service Updated Successfully!');
        return redirect()->route('service.show');
    }

    public function delete(Request $request)
    {
        $latestnews = Service::where('id', $request->id)->first();
        $file_path_image = public_path() . '/service/' . $latestnews->image;
        File::delete($file_path_image);
        $latestnews->delete();
        return response()->json();
    }
}
