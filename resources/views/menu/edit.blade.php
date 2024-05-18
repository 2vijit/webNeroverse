@extends('layouts.app')
@section('title'){{ 'Menu' }}@endsection
@section('header.css')
    <style>
        html body .content .content-wrapper {
            padding: 5px 20px 5px 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('menu.show') }}">Menu</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>

                    </ol>
                </div>
                <h4 class="page-title">Edit Menu</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">

                    <form class="form" action="{{ route('menu.update', $menu->menuId) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mt-2">
                                <label>Name</label>
                                {{-- <input type="text" class="form-control" placeholder="Name" value="{{ $menu->menuName }}" name="menuName"> --}}
                                <input class="form-control"  name="menuName" type="text" placeholder="Menu Name" value="{{ $menu->menuName }}" >
                                <span class="text-danger"> <b>{{  $errors->first('menuName') }}</b></span>
                            </div>
                         
                            {{-- <div class="form-group mt-2">
                                <label>Parent</label>
                                <select name="parent" class="form-control">
                                    <option value="">Select Parent Menu</option>
                                    @foreach($menus as $menuAll)
                                        <option value="{{ $menuAll->id }}" @if($menuAll->id == $menu->parent) selected @endif>{{ $menuAll->menuName }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('parent') }}</b></span>
                            </div> --}}
                            <div class="form-group mt-2">
                                <label>Menu Order</label>
                                <input type="number" class="form-control" value="{{ $menu->menuOrder }}" name="menuOrder">
                                <span class="text-danger"> <b>{{  $errors->first('menuOrder') }}</b></span>
                            </div>
                            <div class="form-group mt-2">
                                <label>Menu Type</label>
                                <select name="menuType" class="form-control">
                                    <option value="">Select Menu Type</option>
                                    <option value="header" @if($menu->menuType == "header") selected @endif>Header</option>
                                    <option value="footer" @if($menu->menuType == "footer") selected @endif>Footer</option>
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('parent') }}</b></span>
                            </div>
                            <div class="form-group mt-2">
                                <label>Page Link</label>
                                <input type="text" class="form-control" placeholder="Page Link" value="{{ $menu->pageLink }}" name="pageLink">
                                <span class="text-danger"> <b>{{  $errors->first('pageLink') }}</b></span>
                            </div>
                            <div class="form-group mt-2">
                                <label>Page</label>
                                <select name="fkPageId" class="form-control">
                                    <option value="">Select Page</option>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->pageId }}" @if($page->pageId == $menu->fkPageId) selected @endif>{{ $page->pageTitle }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('fkpageId') }}</b></span>
                            </div>

                            <div class="form-group mt-2">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Select Menu Status</option>
                                <option value="active" @if($menu->status === 'active') selected @endif>Active</option>
                                <option value="inactive" @if($menu->status === 'inactive') selected @endif>Inactive</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-actions mt-2">
                            <a href="{{ route('menu.show') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
