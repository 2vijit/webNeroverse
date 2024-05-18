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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('team.show') }}">Team</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Add</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Create Team Member</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form class="form" action="{{ route('team.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mb-2">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="Team Name" value="{{ old('name') }}" name="name" required>
                                <span class="text-danger"> <b>{{  $errors->first('name') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Name (Bangla)</label>
                                <input type="text" class="form-control" placeholder="Team Name in Bangla" value="{{ old('nameBangla') }}" name="nameBangla" required>
                                <span class="text-danger"> <b>{{  $errors->first('nameBangla') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Email" value="{{ old('mail') }}" name="mail" required>
                                <span class="text-danger"> <b>{{  $errors->first('mail') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" placeholder="Designation" value="{{ old('designation') }}" name="designation" required>
                                <span class="text-danger"> <b>{{  $errors->first('designation') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Designation (Bangla)</label>
                                <input type="text" class="form-control" placeholder="Designation in Bangla" value="{{ old('designationBangla') }}" name="designationBangla" required>
                                <span class="text-danger"> <b>{{  $errors->first('designationBangla') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Facebook</label>
                                <input type="text" class="form-control" placeholder="Facebook" value="{{ old('facebook') }}" name="facebook">
                                <span class="text-danger"> <b>{{  $errors->first('facebook') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Instagram</label>
                                <input type="text" class="form-control" placeholder="Instagram" value="{{ old('instagram') }}" name="instagram">
                                <span class="text-danger"> <b>{{  $errors->first('instagram') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Twitter</label>
                                <input type="text" class="form-control" placeholder="Twitter" value="{{ old('twitter') }}" name="twitter">
                                <span class="text-danger"> <b>{{  $errors->first('twitter') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" required>
                                <span class="text-danger"> <b>{{  $errors->first('image') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Alt Tag</label>
                                <input type="text" class="form-control" placeholder="Alt Tag" value="{{ old('alt_tag') }}" name="alt_tag">
                                <span class="text-danger"> <b>{{  $errors->first('alt_tag') }}</b></span>
                            </div>
                        </div>

                        <div class="form-actions mb-2">
                            <a href="{{ route('team.show') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Create</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
