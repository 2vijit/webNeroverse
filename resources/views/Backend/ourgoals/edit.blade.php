@extends('layouts.app')
@section('title'){{ 'Goals Update' }}@endsection
@section('header.css')
<style>
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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('goals.show') }}">Our Goals</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                </ol>
            </div>
            <h4 class="page-title">Edit Goals</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('goals.update', $works->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group mb-2">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" placeholder="Department Title"
                                value="{{ @$works->title }}" name="title">
                            <span class="text-danger"> <b>{{ $errors->first('Department Title') }}</b></span>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Description</label>
                            <textarea type="text" class="form-control" placeholder="Decription"
                                name="description">{{ @$works->description }}</textarea>
                            <span class="text-danger"> <b>{{ $errors->first('description') }}</b></span>
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="">Select status</option>
                                <option value="active" @if($works->status == 'active') selected @endif>Active</option>
                                <option value="inactive" @if($works->status == 'inactive') selected @endif>Inactive
                                </option>
                            </select>
                            <span class="text-danger"> <b>{{ $errors->first('status') }}</b></span>
                        </div>

                        <div class="form-actions mb-2">
                            <a href="{{ route('goals.show') }}"><button type="button" class="btn btn-danger mr-1"><i
                                        class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i>
                                Update</button>
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