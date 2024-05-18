@extends('layouts.app')
@section('title'){{ 'Case Study' }}@endsection
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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Case Study</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Add</a></li>
                </ol>
            </div>
            <h4 class="page-title">Create Case Study</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('casestudy.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">

                        <div class="form-group mt-2">
                            <label>Title</label>
                            <input name="title" id="" class="form-control" placeholder="Title" required>
                            <span class="text-danger"> <b>{{ $errors->first('title') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Description</label>
                            <textarea name="description" id="" class="form-control" placeholder="Description"
                                required></textarea>
                            <span class="text-danger"> <b>{{ $errors->first('description') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Image</label>
                            <input name="image" id="" class="form-control" placeholder="Image" type="file" required>
                            <span class="text-danger"> <b>{{ $errors->first('image') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Pagelink</label>
                            <input name="page_link" id="" class="form-control" placeholder="Page Link" required>
                            <span class="text-danger"> <b>{{ $errors->first('page_link') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>

                            <span class="text-danger"> <b>{{ $errors->first('status') }}</b></span>
                        </div>

                    </div>

                    <div class="form-actions mt-2">
                        <a href="{{route('casestudy.show')}}"><button type="button" class="btn btn-danger mr-1"><i
                                    class="ft-x"></i> Cancel</button></a>
                        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i>
                            Create</button>
                    </div>
                </form>
            </div>
        </div> <!-- end card -->
    </div>
    <!-- end col -->
</div>
@endsection

@section('footer.js')


@endsection