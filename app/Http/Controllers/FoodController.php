<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Restaurent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class FoodController extends Controller
{

    public function show()
    {
        return view('food.index');
    }

    public function list()
    {
        $foods = Restaurent::all();

        return datatables()->of($foods)

            ->addColumn('status', function (Restaurent $status) {
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

    public function store(Request $request)
    {
        //    dd($request->id);
        $this->validate($request, [
            'name' => 'required|max:255',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $restaurent = new Restaurent();
        $restaurent->title = $request->title;
        $restaurent->schedule = $request->schedule;
        $restaurent->orders = $request->orders;
        $restaurent->status = $request->status;
        $restaurent->save();

        foreach ($request->name as $key => $foods) {
            $food = new Food();
            $food->name = $foods;
            $food->detail = $request->detail[$key];
            $food->price = $request->price[$key];
            $food->type = $request->type[$key];
            $food->status = $request->food_status[$key];
            $food->fkRestaurentId = $restaurent->id;
            if ($request->hasFile('image')) {
                // Assuming you have multiple images for each food item
                $foodImages = $request->file('image');
                $foodImage = $foodImages[$key] ?? null;
                if ($foodImage) {
                    $images = $request->file('image');
                    $originalName = $images[$key]->getClientOriginalName();
                    $uniqueImageName = $request->name[$key] . rand(1000, 9999) . $originalName;
                    $image = Image::make($images[$key]);
                    $image->save(public_path() . '/foodImage/' . $uniqueImageName);
                    $food->image = $uniqueImageName;
                }
            }
            $food->save();
        }

        Session::flash('success', 'Food Updated Successfully');
        return redirect()->route('food.show');
    }

    public function create()
    {
        return view('food.create');
    }

    public function edit($id)
    {
        $restaurent = Restaurent::where('id', $id)->first();
        $food = Food::query()->where('fkRestaurentId', $id)->get();
        return view('food.edit', compact('food', 'restaurent'));
    }

    public function update(Request $request)
    {

        // $validated=$this->validate($request , [
        //     'name' => 'required|max:255',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg',
        // ]);

        $restaurent = Restaurent::where('id', $request->id)->first();
        $restaurent->title = $request->title;
        $restaurent->schedule = $request->schedule;
        $restaurent->status = $request->status;
        $restaurent->orders = $request->orders;
        $restaurent->save();


        if (isset($request->food_id)) {
            foreach ($request->food_id as $key => $i_id) {
                $food = Food::find($i_id);

                if ($food) {
                    $food->name = $request->name[$key];
                    $food->price = $request->price[$key];
                    $food->detail = $request->detail[$key];
                    $food->type = $request->type[$key];
                    $food->status = $request->food_status[$key];
                    if ($request->hasFile('image')) {
                        // Assuming you have multiple images for each food item
                        $foodImages = $request->file('image');
                        $foodImage = $foodImages[$key] ?? null;
                        if ($foodImage) {
                            $images = $request->file('image');
                            $originalName = $images[$key]->getClientOriginalName();
                            $uniqueImageName = $request->name[$key] . rand(1000, 9999) . $originalName;
                            $image = Image::make($images[$key]);
                            $image->save(public_path() . '/foodImage/' . $uniqueImageName);
                            $food->image = $uniqueImageName;
                        }
                    }
                    $food->save();
                }
            }
        }

        if (!empty($request->f_name)) {
            foreach ($request->f_name as $key => $f_title) {
                $f_food = new Food();
                $f_food->name = $f_title;
                $f_food->price = $request->f_price[$key];
                $f_food->detail = $request->f_detail[$key];
                $f_food->type = $request->f_type[$key];
                $f_food->status = $request->f_food_status[$key];

                if ($request->hasFile('f_image')) {
                    // Assuming you have multiple images for each food item
                    $foodImages = $request->file('f_image');

                    $foodImage = $foodImages[$key] ?? null;
                    if ($foodImage) {
                        $images = $request->file('f_image');
                        $originalName = $images[$key]->getClientOriginalName();
                        $uniqueImageName = $request->name[$key] . rand(1000, 9999) . $originalName;
                        $image = Image::make($images[$key]);
                        $image->save(public_path() . '/foodImage/' . $uniqueImageName);
                        $f_food->image = $uniqueImageName;
                    }
                }
                $f_food->fkRestaurentId = $restaurent->id;
                $f_food->save();
            }
        }

        Session::flash('success', 'Food Updated Successfully');
        return redirect()->route('food.show');
    }

    public function delete(Request $request)
    {
        $restaurent = Restaurent::find($request->id);

        if (!$restaurent) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        foreach ($restaurent->foods as $food) {
            $file_path_image = public_path() . '/foodImage/' . $food->image;
            File::delete($file_path_image);
        }
        // Delete related records from the 'food' table
        $restaurent->foods()->delete();
        // Delete the 'restaurent' record
        $restaurent->delete();
        return response()->json();
    }

    public function deleteFood(Request $request)
    {
        $food = Food::find($request->foodId);

        if (!$food) {
            return response()->json(['error' => 'Food not found'], 404);
        }

        // Delete the food image
        $file_path_image = public_path() . '/foodImage/' . $food->image;
        File::delete($file_path_image);

        // Delete the 'food' record
        $food->delete();

        return response()->json();
    }
}
