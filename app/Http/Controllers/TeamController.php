<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    use ImageTrait;
    public function show()
    {
        return view('Backend.team.index');
    }

    public function list()
    {
        $latestnews = Team::query()->get();
        return datatables()->of($latestnews)
            ->addColumn('image', function (Team $latestnews) {
                if (isset($latestnews->image)) {
                    return '<img height="50px" width="50px" src="' . url($latestnews->image) . '" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (Team $latestnews) {
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
        return view('Backend.team.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        $latestnews = Team::query()->create([
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'status' => $validated['status'],
            'image' => $this->save_image('team', $validated['image']),
        ]);

        Session::flash('success', 'Team Created Successfully!');
        return redirect()->route('team.show');
    }

    public function edit($id)
    {
        $latestnews = Team::where('id', $id)->first();
        return view('Backend.team.edit', compact('latestnews'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $this->validate($request, [
            'name' => 'nullable',
            'designation' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable',
        ]);

        $latestnews = Team::query()->where('id', $id)->first();
        if (!empty($latestnews)) {
            if (empty($validated['image'])) {
                $imageLink = $latestnews->image;
            } else {
                $this->deleteImage($latestnews->image);
                $imageLink = $this->save_image('Team', $validated['image']);
            }

            $latestnews->update([
                'name' => $validated['name'],
                'designation' => $validated['designation'],
                'status' => $validated['status'],
                'image' => $imageLink,
            ]);
        }

        Session::flash('success', 'Team Updated Successfully!');
        return redirect()->route('team.show');
    }

    public function delete(Request $request)
    {
        $latestnews = Team::where('id', $request->id)->first();
        $file_path_image = public_path() . '/team/' . $latestnews->image;
        File::delete($file_path_image);
        $latestnews->delete();
        return response()->json();
    }

    public function deleteServiceImage(Request $request)
    {
        $service = Service::find($request->foodId);
        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }
        $file_path_image = public_path() . '/service/' . $service->image;
        File::delete($file_path_image);
        $service->delete();
        return response()->json();
    }
}
