<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\assertDirectoryDoesNotExist;

class UserTypeController extends Controller
{
    public function show()
    {
        return view('userType.index');
    }

    public function list()
    {
        $userType = UserType::all();
        return datatables()->of($userType)
            ->addColumn('status', function (UserType $userType) {
                if ($userType->status == "active") {
                    return "<label style='width: auto' class='btn btn-success btn-sm'>Active</label>";
                } else {
                    return "<label class='btn btn-danger btn-sm'>Inactive</label>";
                }
            })
            ->setRowAttr([
                'align' => 'center',
            ])
            ->rawColumns(['status'])
            ->make(true);
    }

    public function create()
    {
        return view('userType.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type_name' => 'required|unique:user_types',
            'status' => 'required'
        ]);

        $userType = new UserType();
        $userType->type_name = $request->type_name;
        $userType->status = $request->status;
        $userType->save();

        Session::flash('success', 'User Type Created Successfully');
        return redirect()->route('userType.show');
    }

    public function edit($id)
    {
        $userType = UserType::where('id', $id)->first();
        return view('userType.edit', compact('userType'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type_name' => 'required|unique:user_types,type_name,' . $id,
            'status' => 'required'
        ]);

        $userType = UserType::findOrFail($id);
        $userType->type_name = $request->type_name;
        $userType->status = $request->status;
        $userType->save();

        if ($request->status == 'Inactive') {
            User::where('fkuserTypeId', $userType->id)->update(array('fkuserTypeId' => NULL));
        }

        Session::flash('success', 'User Type Updated Successfully');
        return redirect()->route('userType.show');
    }

    public function delete(Request $request)
    {
        $userType = UserType::where('id', $request->id)->first();
        User::where('fkuserTypeId', $userType->id)->update(array('fkuserTypeId' => NULL));
        $userType->delete();
        return response()->json();
    }
}
