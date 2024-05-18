<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('user.index');
    }

    public function list()
    {
        $users = User::with('user_type')->where('fkuserTypeId', 1)->get();
        return datatables()->of($users)
            ->addColumn('image', function (User $user) {
                if (isset($user->image)) {
                    return '<img src="' . url('public/user_image/' . $user->image) . '" border="0" width="50px" height="30px" class="img-rounded" align="center" alt="' . $user->alt_tag . '"/>';
                }

                return '';
            })
            ->addColumn('user_type', function (User $user) {
                if ($user->fkuserTypeId !== null) {
                    return $user->user_type->type_name;
                }

                return '';
            })
            ->setRowAttr([
                'align' => 'center',
            ])
            ->rawColumns(['image', 'user_type'])
            ->make(true);
    }

    public function edit_profile($id)
    {
        $user = User::query()->findOrFail($id);
        return view('profile.index', compact('user'));
    }

    public function update_profile(Request $request, $id): RedirectResponse
    {
        $user = User::where('id', $request->id)->first();

        if (!$user) {
            Session::flash('error', 'No user found!');
            return redirect()->back();
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Check if a new password is provided
        if ($request->filled('new_password')) {
            // Validate and hash the new password
            $this->validate($request, [
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|string|min:8|same:new_password',
            ]);

            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        Session::flash('success', 'User profile updated successfully!');
        return redirect()->back();
    }
}
