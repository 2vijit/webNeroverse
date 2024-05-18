<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AgentController extends Controller
{
    public function show()
    {
        return view('agent.index');
    }

    public function list()
    {
        $user = User::query()->where('type', 'agent')->get();
        return datatables()->of($user)

            ->setRowAttr([
                'align' => 'center',
            ])
            ->make(true);
    }

    public function create()
    {
        return view('agent.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'nullable|string|min:8',
            'phone' => 'required',
            'address' => 'required',

            'status' => 'required',
        ]);


        if (empty($validated['password'])) {
            $validated['password'] = '123456789';
        }


        $User = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'type' => 'agent',
            'status' => $validated['status'],
            'password' => Hash::make($validated['password']),
        ]);

        Session::flash('success', 'User Created Successfully!');
        return redirect()->route('agent.show');
    }
}
