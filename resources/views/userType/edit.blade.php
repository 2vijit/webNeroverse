@extends('layouts.app')
@section('title'){{ 'User Type' }}@endsection
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
                        <li class="breadcrumb-item"><a href="{{ route('userType.show') }}">User Type</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Edit User Type</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form class="form" action="{{ route('userType.update', $userType->id) }}" method="post">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mb-2">
                                <label class="form-label">User Type Name</label>
                                <input type="text" class="form-control"  value="{{ $userType->type_name }}" name="type_name" required>
                                <span class="text-danger"> <b>{{  $errors->first('type_name') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option @if($userType->status == "active") selected @endif value="active">Active</option>
                                    <option @if($userType->status == "inactive") selected @endif value="inactive">Inactive</option>
                                </select>
                                <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <a href="{{ route('userType.show') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
