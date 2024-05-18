<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Works;
use Illuminate\Http\Request;
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

        // $this->validate($request, [
        //     'name' => 'required|max:255',
        //     'description' => 'required',
        //     'status' => 'required',
        // ]);

        $work = new Works();
        $work->title = $request->title;
        $work->description = $request->description;
        $work->status = $request->status;
        $work->save();
        Session::flash('success', 'Department Created Successfully');
        return redirect()->route('department.show');
    }



    public function edit($id)
    {
        $works = Works::where('id', $id)->first();
        return view('Backend.work.edit', compact('works'));
    }

    public function update(Request $request)
    {

        $works = Works::where('id', $request->id)->first();
        $works->title = $request->title;
        $works->description = $request->description;
        $works->status = $request->status;
        $works->save();
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
