<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OurGoals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OurGoalController extends Controller
{
    public function show()
    {
        return view('Backend.ourgoals.index');
    }

    public function list()
    {
        $goals = OurGoals::all();

        return datatables()->of($goals)

            ->addColumn('status', function (OurGoals $goals) {
                if ($goals->status == 'active') {
                    return "<span class='btn btn-success'>Active</span>";
                } elseif ($goals->status == 'inactive') {
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
        return view('Backend.ourgoals.create');
    }

    public function store(Request $request)
    {

        // $this->validate($request, [
        //     'name' => 'required|max:255',
        //     'description' => 'required',
        //     'status' => 'required',
        // ]);

        $goals = new OurGoals();
        $goals->title = $request->title;
        $goals->description = $request->description;
        $goals->status = $request->status;
        $goals->save();
        Session::flash('success', 'Our Goals Created Successfully');
        return redirect()->route('goals.show');
    }



    public function edit($id)
    {
        $works = OurGoals::where('id', $id)->first();
        return view('Backend.work.edit', compact('goals'));
    }

    public function update(Request $request)
    {

        $works = OurGoals::where('id', $request->id)->first();
        $works->title = $request->title;
        $works->description = $request->description;
        $works->status = $request->status;
        $works->save();
        Session::flash('success', 'Works Updated Successfully');
        return redirect()->route('department.show');
    }

    public function delete(Request $request)
    {
        $works = OurGoals::find($request->id);

        if (!$works) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $works->delete();
        return response()->json();
    }
}
