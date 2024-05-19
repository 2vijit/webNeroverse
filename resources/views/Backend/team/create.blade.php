@extends('layouts.app')
@section('title'){{ 'Team' }}@endsection
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
                    <li class="breadcrumb-item"><a href="">Team</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Add</a></li>
                </ol>
            </div>
            <h4 class="page-title">Create Team</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('team.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group mt-2">
                            <label>Name</label>
                            <input name="name" id="" class="form-control" placeholder="Name" required>
                            <span class="text-danger"> <b>{{ $errors->first('name') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Designation</label>
                            <input name="designation" id="" class="form-control" placeholder="Designation" required>
                            <span class="text-danger"> <b>{{ $errors->first('designation') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Image</label>
                            <input name="image" id="" class="form-control" placeholder="Image" type="file" required>
                            <span class="text-danger"> <b>{{ $errors->first('image') }}</b></span>
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
                        <a href="{{route('team.show')}}"><button type="button" class="btn btn-danger mr-1"><i
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