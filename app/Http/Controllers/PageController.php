<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Page;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    use ImageTrait;

    public function index()
    {
        return view('page.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $page = Page::all();
        return datatables()->of($page)
            ->addColumn('image', function (Page $page) {
                if (isset($page->image)) {
                    return '<img height="50px" width="50px" src="' . url($page->image) . '" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (Page $page) {
                if ($page->status === 'active') {
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
        return view('page.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'pageTitle' => 'required|string|max:255',
            'details' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required|string|max:45',
        ]);

        Page::query()->create([
            'pageTitle' => $validated['pageTitle'],
            'details' => $validated['details'],
            'image' => isset($validated['image']) ? $this->save_image('pageImage', $validated['image']) : null,
            'status' => $validated['status'],
        ]);

        Session::flash('success', 'Page Created Successfully!');
        return redirect()->route('page.show');
    }

    public function edit($pageId)
    {
        $page = Page::query()->where('pageId', $pageId)->first();
        return view('page.edit', compact('page'));
    }

    public function update(Request $request, $pageId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'pageTitle' => 'required|string|max:255',
            'details' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required|string|max:45',
        ]);

        $page = Page::query()->where('pageId', $pageId)->first();
        if (!empty($page)) {
            if (empty($validated['image'])) {
                $image = $page->image;
            } else {
                $this->deleteImage($page->image);
                $image = $this->save_image('pageImage', $validated['image']);
            }

            $page->update([
                'pageTitle' => $validated['pageTitle'],
                'details' => $validated['details'],
                'image' => $image,
                'status' => $validated['status'],
            ]);

            if (!empty($validated['status']) && $validated['status'] === 'inactive') {
                $menu = Menu::query()->where('fkPageId', $page->pageId)->first();
                if (!empty($menu)) {
                    $menu->update([
                        'status' => 'inactive',
                    ]);
                }
            }
        }

        Session::flash('success', 'Page Updated Successfully!');
        return redirect()->route('page.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $page = Page::query()->where('pageId', $request->pageId)->first();
        if (!empty($page)) {
            $menu = Menu::query()->where('fkPageId', $page->pageId)->first();
            if (!empty($menu)) {
                $menu->delete();
            }
            $page->delete();
        }
        return response()->json();
    }
}
