@extends('layouts.app')
@section('title'){{ 'Page' }}@endsection
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
                        <li class="breadcrumb-item"><a href="{{ route('page.show') }}">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Add</a></li>

                    </ol>
                </div>
                <h4 class="page-title">Create Page</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-md-2">

            <div class="card">
                <div class="card-body">

                    <form class="form" action="{{ route('page.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mt-2">
                                <label>Title</label>
                                <input class="form-control" id="pageTitle" name="pageTitle" type="text" placeholder="Page Title" value="{{ old('pageTitle') }}" required>
                                <span class="text-danger"> <b>{{  $errors->first('title') }}</b></span>
                            </div>
                         
                            <div class="form-group mt-2">
                                <label>Detail</label>
                                <textarea class="form-control" id="details" name="details" placeholder="Page Details" required>{{ old('details') }}</textarea>
                                <span class="text-danger"> <b>{{  $errors->first('details') }}</b></span>
                            </div>

                            <div class="form-group mt-2">
                                <label>Image</label>
                                <input class="form-control" id="image" name="image" type="file">
                                <span class="text-danger"> <b>{{  $errors->first('image') }}</b></span>
                            </div>
                         
                            <div class="form-group mt-2">
                                <label>Status</label>
                                <select class="form-control" name="status"  required>
                                    <option value="">Select Page Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <a href="{{ route('page.show') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Create</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection

@section('footer.js')
    <script>
        $(document).ready(function(){
            CKEDITOR.replace( 'details' );
            CKEDITOR.replace( 'detailsBangla' );
        });
    </script>
@endsection
