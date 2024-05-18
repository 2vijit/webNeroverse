<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact.index');
    }

    public function list()
    {
        $contacts = Contact::all();

        return datatables()->of($contacts)
            ->setRowAttr([
                'align' => 'center',
            ])->make(true);
    }

    public function detail($id)
    {
        $contact = Contact::where('id', $id)->first();
        return view('contact.detail', compact('contact'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        Session::flash('success', 'Contact Updated Successfully');
        return redirect()->route('contact.show');
    }

    public function create()
    {
        return view('contact.create');
    }

    public function edit($id)
    {
        $contact = Contact::where('id', $id)->first();
        return view('contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $contact = Contact::where('id', $request->id)->first();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        Session::flash('success', 'Contact Updated Successfully');
        return redirect()->route('contact.show');
    }

    public function delete(Request $request)
    {
        $contact = Contact::where('id', $request->id)->first();
        $contact->delete();

        return response()->json();
    }
}
