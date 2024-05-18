@extends('layouts.app')
@section('title'){{ 'Profile' }}@endsection
@section('header.css')
    <style>
        html body .content .content-wrapper {
            padding: 5px 20px 5px 20px;
        }
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="offset-md-1 col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Edit Profile</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('profile.update_profile', $user->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Name</label>
                                                        <input class="form-control input-text" type="text" name="name" id="name" placeholder="Name" value="{{ Auth::user()->name }}" title="Your Name">
                                                        <span class="text-danger"><b>{{  $errors->first('name') }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input class="form-control input-text email-field" type="email" name="email" id="email" placeholder="Email" value="{{ Auth::user()->email }} " title="Your Email">
                                                        <span class="text-danger"><b>{{  $errors->first('email') }}</b></span>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Phone</label>
                                                        <input class="form-control input-text" type="text" maxlength="20" name="phone" id="phone" placeholder="Phone Number" value="{{ Auth::user()->phone }}" title="Your Phone Number">
                                                        <span class="text-danger"><b>{{  $errors->first('phone') }}</b></span>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Image Alt Tag</label>
                                                        <input type="text" class="form-control" placeholder="Image Alt Tag" value="{{ Auth::user()->alt_tag }}" name="alt_tag">
                                                        <span class="text-danger"> <b>{{  $errors->first('alt_tag') }}</b></span>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Profile Image</label>
                                                        <input type="file" class="form-control"  name="image">
                                                        <span class="text-danger"> <b>{{  $errors->first('image') }}</b></span>
                                                    </div>
                                                </div> --}}
                                                {{-- @if(isset(Auth::user()->image) && !empty(Auth::user()->image))
                                                    <input type="hidden" name="image" value="{{Auth::user()->image}}">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <img height="100px" width="100px" src="{{url(Auth::user()->image)}}" alt="{{ Auth::user()->alt_tag }}">
                                                        </div>
                                                    </div>
                                                @endif --}}
                                                <div class="col-md-12">
                                                    <h4 class="card-title">Change Password</h4>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <input class="form-control input-text" id="current_password" name="current_password" placeholder="Current Password" type="password" title="Current Password">
                                                        <span class="text-danger"> <b>{{  $errors->first('current_password') }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <input class="form-control input-text" type="password" name="new_password" id="new_password" placeholder="New Password" title="New Password">
                                                        <span class="text-danger"><b>{{ $errors->first('new_password') }}</b></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <input class="form-control input-text" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" title="Confirm Password">
                                                        <span class="text-danger"><b>{{  $errors->first('confirm_password') }}</b></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <a href="{{ route('home') }}"><button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
                                                <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
