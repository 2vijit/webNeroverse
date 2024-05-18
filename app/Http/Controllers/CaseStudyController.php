<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class CaseStudyController extends Controller
{
    use ImageTrait;
    public function show()
    {
        return view('Backend.casestudy.index');
    }

    public function list()
    {
        $latestnews = CaseStudy::query()->get();
        return datatables()->of($latestnews)
            ->addColumn('image', function (CaseStudy $latestnews) {
                if (isset($latestnews->image)) {
                    return '<img height="50px" width="50px" src="' . url($latestnews->image) . '" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (CaseStudy $latestnews) {
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
        return view('Backend.casestudy.create');
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

        $latestnews = CaseStudy::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'page_link' => $validated['page_link'],
            'image' => $this->save_image('casestudy', $validated['image']),
        ]);

        Session::flash('success', 'casestudy New Created Successfully!');
        return redirect()->route('casestudy.show');
    }

    public function edit($id)
    {
        $latestnews = CaseStudy::where('id', $id)->first();
        return view('Backend.casestudy.edit', compact('latestnews'));
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

        $latestnews = CaseStudy::query()->where('id', $id)->first();
        if (!empty($latestnews)) {
            if (empty($validated['image'])) {
                $imageLink = $latestnews->image;
            } else {
                $this->deleteImage($latestnews->image);
                $imageLink = $this->save_image('casestudy', $validated['image']);
            }

            $latestnews->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'page_link' => $validated['page_link'],
                'image' => $imageLink,
            ]);
        }

        Session::flash('success', 'casestudy News Updated Successfully!');
        return redirect()->route('casestudy.show');
    }

    public function delete(Request $request)
    {
        $latestnews = CaseStudy::where('id', $request->id)->first();
        $file_path_image = public_path() . '/casestudy/' . $latestnews->image;
        File::delete($file_path_image);
        $latestnews->delete();
        return response()->json();
    }
}
