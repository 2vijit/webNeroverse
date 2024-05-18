@extends('layouts.app')
@section('title'){{ 'Setting' }}@endsection
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Create Setting</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('setting.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="form-group mb-2">
                                <label class="form-label">Company Name</label>
                                <input class="form-control" type="text" name="companyName" placeholder="Company Name" id="example-search-input" value="{{ old('companyName') }}" required>
                                @if ($errors->has('companyName'))
                                    <span class="text-danger"><strong>{{ $errors->first('companyName') }}</strong> </span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Company Name (Bangla)</label>
                                <input class="form-control" type="text" name="companyNameBangla" placeholder="Company Name in Bangla" id="example-search-input" value="{{ old('companyNameBangla') }}" required>
                                @if ($errors->has('companyNameBangla'))
                                    <span class="text-danger"><strong>{{ $errors->first('companyNameBangla') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Email" id="example-search-input" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger"><strong>{{ $errors->first('email') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Phone</label>
                                <input class="form-control" type="text" maxlength="20" name="phone" placeholder="Company Phone" id="example-search-input" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="text-danger"><strong>{{ $errors->first('phone') }}</strong> </span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Phone (Bangla)</label>
                                <input class="form-control" type="text" maxlength="20" name="phoneBangla" placeholder="Company Phone in Bangla" id="example-search-input" value="{{ old('phoneBangla') }}">
                                @if ($errors->has('phoneBangla'))
                                    <span class="text-danger"><strong>{{ $errors->first('phoneBangla') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Company Logo 1</label>
                                <input class="form-control" type="file" name="logo_1">
                                @if ($errors->has('logo_1'))
                                    <span class="text-danger"><strong>{{ $errors->first('logo_1') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Logo 1 Alt Tag</label>
                                <input class="form-control" type="text" name="logo_1_alt_tag" placeholder="Logo 1 Alt Tag" id="example-search-input" value="{{ old('logo_1_alt_tag') }}">
                                @if ($errors->has('logo_1_alt_tag'))
                                    <span class="text-danger"><strong>{{ $errors->first('logo_1_alt_tag') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Company Logo 2</label>
                                <input class="form-control" type="file" name="logo_2">
                                @if ($errors->has('logo_2'))
                                    <span class="text-danger"><strong>{{ $errors->first('logo_2') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Logo 2 Alt Tag</label>
                                <input class="form-control" type="text" name="logo_2_alt_tag" placeholder="Logo 2 Alt Tag" id="example-search-input" value="{{ old('logo_2_alt_tag') }}">
                                @if ($errors->has('logo_2_alt_tag'))
                                    <span class="text-danger"><strong>{{ $errors->first('logo_2_alt_tag') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Address</label>
                                <input class="form-control" type="text" name="address" placeholder="Address" id="example-search-input" value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <span class="text-danger"><strong>{{ $errors->first('address') }}</strong> </span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Address (Bangla)</label>
                                <input class="form-control" type="text" name="addressBangla" placeholder="Address in Bangla" id="example-search-input" value="{{ old('addressBangla') }}">
                                @if ($errors->has('addressBangla'))
                                    <span class="text-danger"><strong>{{ $errors->first('addressBangla') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Facebook</label>
                                <input class="form-control" type="text" name="facebook" placeholder="Facebook" id="example-search-input" value="{{ old('facebook') }}">
                                @if ($errors->has('facebook'))
                                    <span class="text-danger"><strong>{{ $errors->first('facebook') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Instagram</label>
                                <input class="form-control" type="text" name="instagram" placeholder="Instagram" id="example-search-input" value="{{ old('instagram') }}">
                                @if ($errors->has('instagram'))
                                    <span class="text-danger"><strong>{{ $errors->first('instagram') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">LinkedIn</label>
                                <input class="form-control" type="text" name="linkedin" placeholder="LinkedIn" id="example-search-input" value="{{ old('linkedin') }}">
                                @if ($errors->has('linkedin'))
                                    <span class="text-danger"><strong>{{ $errors->first('linkedin') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Youtube</label>
                                <input class="form-control" type="text" name="youtube" placeholder="Youtube" id="example-search-input" value="{{ old('youtube') }}">
                                @if ($errors->has('youtube'))
                                    <span class="text-danger"><strong>{{ $errors->first('youtube') }}</strong> </span>
                                @endif
                            </div>

                            <div class="form-actions mt-2">
                                <a href="{{ route('setting.show') }}">
                                    <button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel </button>
                                </a>
                                <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
