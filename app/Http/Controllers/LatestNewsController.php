<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LatestNews;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class LatestNewsController extends Controller
{
    use ImageTrait;
    public function show()
    {
        return view('Backend.latestnews.index');
    }

    public function list()
    {
        $latestnews = LatestNews::query()->get();
        return datatables()->of($latestnews)
            ->addColumn('image', function (LatestNews $latestnews) {
                if (isset($latestnews->image)) {
                    return '<img height="50px" width="50px" src="' . url($latestnews->image) . '" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (LatestNews $latestnews) {
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
        return view('Backend.latestnews.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
            'page_link' => 'required',
        ]);

        $latestnews = LatestNews::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'page_link' => $validated['page_link'],
            'image' => $this->save_image('latestnews', $validated['image']),
        ]);

        Session::flash('success', 'Latest New Created Successfully!');
        return redirect()->route('latestnews.show');
    }

    public function edit($id)
    {
        $latestnews = LatestNews::where('id', $id)->first();
        return view('Backend.latestnews.edit', compact('latestnews'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $this->validate($request, [
            'title' => 'nullable',
            'description' => 'nullable',
            'page_link' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable',
        ]);

        $latestnews = LatestNews::query()->where('id', $id)->first();
        if (!empty($latestnews)) {
            if (empty($validated['image'])) {
                $imageLink = $latestnews->image;
            } else {
                $this->deleteImage($latestnews->image);
                $imageLink = $this->save_image('latestnews', $validated['image']);
            }

            $latestnews->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'page_link' => $validated['page_link'],
                'image' => $imageLink,
            ]);
        }

        Session::flash('success', 'Latest News Updated Successfully!');
        return redirect()->route('latestnews.show');
    }

    public function delete(Request $request)
    {
        $latestnews = LatestNews::where('id', $request->id)->first();
        $file_path_image = public_path() . '/latestnews/' . $latestnews->image;
        File::delete($file_path_image);
        $latestnews->delete();
        return response()->json();
    }
}
