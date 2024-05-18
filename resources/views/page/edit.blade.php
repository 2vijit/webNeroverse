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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>

                    </ol>
                </div>
                <h4 class="page-title">Edit Page</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">

                    <form class="form" action="{{ route('page.update', $page->pageId) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mt-2">
                                <label>Title</label>
                                <input class="form-control" id="pageTitle" name="pageTitle" type="text" placeholder="Page Title" value="{{ @$page->pageTitle }}" required>
                                <span class="text-danger"> <b>{{  $errors->first('title') }}</b></span>
                            </div>                 
                            <div class="form-group mt-2">
                                <label>Detail</label>
                                <textarea class="form-control" id="details" name="details" placeholder="Page Details" required>{!! @$page->details !!}</textarea>
                                <span class="text-danger"> <b>{{  $errors->first('details') }}</b></span>
                            </div> 

                            <div class="form-group mt-2">
                                <label>Image</label>
                                <input class="form-control" id="image" name="image" type="file">
                                <span class="text-danger"> <b>{{  $errors->first('image') }}</b></span>
                            </div> 
                            @if(isset($page->image))
                            <div class="mb-3">
                                <img height="100px" width="100px" src="{{ url(@$page->image) }}" alt="">
                            </div>
                            @endif  

                            <div class="form-group mt-2">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="active" @if($page->status === "active") selected @endif>Active</option>
                                    <option value="inactive" @if($page->status === "inactive") selected @endif>Inactive</option>
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <a href="{{ route('page.show') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Update</button>
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
