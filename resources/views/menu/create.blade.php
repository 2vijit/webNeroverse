@extends('layouts.app')
@section('title'){{ 'Menu' }}@endsection
@section('header.css')
    <style>
        /* html body .content .content-wrapper {
            padding: 5px 20px 5px 20px;
        } */

        html body .content .content-wrapper {
            padding: 5px 20px 5px 20px;
        }
        .selectOne {
            width: 100%;
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
                        <li class="breadcrumb-item"><a href="">Menu</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Add</a></li>

                    </ol>
                </div>
                <h4 class="page-title">Create Menu</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-md-2">

            <div class="card">
                <div class="card-body">

                    <form class="form" action="{{ route('menu.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mt-2">
                                <label>Name</label>
                                <input class="form-control"  name="menuName" type="text" placeholder="Menu Name" value="{{ old('menuName') }}" required>
                                <span class="text-danger"> <b>{{  $errors->first('menuName') }}</b></span>
                            </div>                         
                            {{-- <div class="form-group mt-2">
                                <label>Parent</label>
                                <select class="form-control" name="parent" id="parent" onchange="checkParentMenu()">
                                    <option value="">Select Parent Menu</option>
                                    @foreach($menus as $menu)
                                    <option value="{{ $menu->menuId }}">{{ $menu->menuName }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('parent') }}</b></span>
                            </div> --}}
                            <div class="form-group mt-2">
                                <label>Menu Order</label>
                                <input class="form-control" id="menuOrder" name="menuOrder" type="number" min="1" placeholder="Menu Order" value="{{ old('menuOrder') }}" required>
                                <span class="text-danger"> <b>{{  $errors->first('menuOrder') }}</b></span>
                            </div>
                            <div class="form-group mt-2">
                                <label>Menu Type</label>
                                <select class="form-control" name="menuType" id="menuType" required>
                                    <option value="">Select Menu Type</option>
                                    <option value="header">Header</option>
                                    <option value="footer">Footer</option>
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('menuType') }}</b></span>
                            </div>
                            <div class="form-group mt-2">
                                <label>Page Link</label>
                                <input type="text" class="form-control" placeholder="Page Link" value="{{ old('pageLink') }}" name="pageLink">
                                <span class="text-danger"> <b>{{  $errors->first('pageLink') }}</b></span>
                            </div>
                            <div class="form-group mt-2">
                                <label>Page</label>
                                <select class="form-control" name="fkPageId" id="fkPageId">
                                    <option value="">Select Page</option>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->pageId }}">{{ $page->pageTitle }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('fkpageId') }}</b></span>
                            </div>

                            <div class="form-group mt-2">
                                <label>Status</label>
                                <select class="form-control" name="status" id="" required>
                                    <option value="">Select Menu Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <a href="{{ route('menu.show') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Create</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
