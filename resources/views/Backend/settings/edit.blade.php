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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                </ol>
            </div>
            <h4 class="page-title">Update Setting</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{route('setting.update',$setting->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group mb-2">
                            <label class="form-label">Company First Name</label>
                            <input class="form-control" type="text" name="companyName" id="companyName"
                                placeholder="Company Name" id="example-search-input" value="{{@$setting->companyName}}">
                            @if ($errors->has('companyName'))
                            <span class="text-danger"><strong>{{ $errors->first('companyName') }}</strong> </span>
                            @endif
                        </div>


                        <div class="form-group mb-2">
                            <label class="form-label">Company Document</label>
                            <input class="form-control" type="file" name="company_document">
                            @if ($errors->has('company_document'))
                            <span class="text-danger"><strong>{{ $errors->first('company_document') }}</strong> </span>
                            @endif
                        </div>


                        <div class="form-group mb-2">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Email"
                                id="example-search-input" value="{{ @$setting->email }}">
                            @if ($errors->has('email'))
                            <span class="text-danger"><strong>{{ $errors->first('email') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Dhaka Office Email</label>
                            <input class="form-control" type="email" name="dhaka_office_email" placeholder="Email"
                                id="example-search-input" value="{{ @$setting->dhaka_office_email }}">
                            @if ($errors->has('dhaka_office_email'))
                            <span class="text-danger"><strong>{{ $errors->first('dhaka_office_email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Phone</label>
                            <input class="form-control" type="text" maxlength="20" name="phone"
                                placeholder="Company Phone" id="example-search-input" value="{{ @$setting->phone }}">
                            @if ($errors->has('phone'))
                            <span class="text-danger"><strong>{{ $errors->first('phone') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Dhaka Office Phone</label>
                            <input class="form-control" type="text" maxlength="20" name="phoneBangla"
                                placeholder="Dhaka Office Phone" id="example-search-input"
                                value="{{ @$setting->phoneBangla }}">
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

                        @if(isset($setting->logo_1))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->logo_1) }}" alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Logo 1 Alt Tag</label>
                            <input class="form-control" type="text" name="logo_1_alt_tag" placeholder="Logo 1 Alt Tag"
                                id="example-search-input" value="{{ @$setting->logo_1_alt_tag }}">
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

                        @if(isset($setting->logo_2))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->logo_2) }}" alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Meta Logo</label>
                            <input class="form-control" type="file" name="meta_logo">
                            @if ($errors->has('meta_logo'))
                            <span class="text-danger"><strong>{{ $errors->first('meta_logo') }}</strong> </span>
                            @endif
                        </div>

                        @if(isset($setting->meta_logo))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->meta_logo) }}" alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Logo 2 Alt Tag</label>
                            <input class="form-control" type="text" name="logo_2_alt_tag" placeholder="Logo 2 Alt Tag"
                                id="example-search-input" value="{{ @$setting->logo_2_alt_tag }}">
                            @if ($errors->has('logo_2_alt_tag'))
                            <span class="text-danger"><strong>{{ $errors->first('logo_2_alt_tag') }}</strong> </span>
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Address</label>
                            <input class="form-control" type="text" name="address" placeholder="Address"
                                id="example-search-input" value="{{ @$setting->address }}">
                            @if ($errors->has('address'))
                            <span class="text-danger"><strong>{{ $errors->first('address') }}</strong> </span>
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Dhaka Office Address</label>
                            <input class="form-control" type="text" name="addressBangla"
                                placeholder="Dhaka Office Address" id="example-search-input"
                                value="{{ @$setting->addressBangla }}">
                            @if ($errors->has('addressBangla'))
                            <span class="text-danger"><strong>{{ $errors->first('addressBangla') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Facebook</label>
                            <input class="form-control" type="text" name="facebook" placeholder="Facebook"
                                id="example-search-input" value="{{ @$setting->facebook }}">
                            @if ($errors->has('facebook'))
                            <span class="text-danger"><strong>{{ $errors->first('facebook') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Instagram</label>
                            <input class="form-control" type="text" name="instagram" placeholder="Instagram"
                                id="example-search-input" value="{{ @$setting->instagram }}">
                            @if ($errors->has('instagram'))
                            <span class="text-danger"><strong>{{ $errors->first('instagram') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">LinkedIn</label>
                            <input class="form-control" type="text" name="linkedin" placeholder="LinkedIn"
                                id="example-search-input" value="{{ @$setting->linkedin }}">
                            @if ($errors->has('linkedin'))
                            <span class="text-danger"><strong>{{ $errors->first('linkedin') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Youtube</label>
                            <input class="form-control" type="text" name="youtube" placeholder="Youtube"
                                id="example-search-input" value="{{ @$setting->youtube }}">
                            @if ($errors->has('youtube'))
                            <span class="text-danger"><strong>{{ $errors->first('youtube') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Accomodation Text</label>
                            <textarea class="form-control" type="text" name="accomodation_text"
                                placeholder="Our Best Text" id="">{{ @$setting->accomodation_text }}</textarea>
                            @if ($errors->has('accomodation_text'))
                            <span class="text-danger"><strong>{{ $errors->first('accomodation_text') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Our Best Text</label>
                            <textarea class="form-control" type="text" name="our_best_text" id="our_best_text"
                                placeholder="Our Best Text" id="">{{ @$setting->our_best_text }}</textarea>
                            @if ($errors->has('our_best_text'))
                            <span class="text-danger"><strong>{{ $errors->first('our_best_text') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Banner Large Text</label>
                            <textarea class="form-control" type="text" name="home_banner_large_text" id=""
                                placeholder="Home Banner Large Text"
                                id="">{{ @$setting->home_banner_large_text }}</textarea>
                            @if ($errors->has('home_banner_large_text'))
                            <span class="text-danger"><strong>{{ $errors->first('home_banner_large_text') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Banner Small Text</label>
                            <textarea class="form-control" type="text" name="home_banner_small_text" id=""
                                placeholder="Home Banner Small Text"
                                id="">{{ @$setting->home_banner_small_text}}</textarea>
                            @if ($errors->has('home_banner_small_text'))
                            <span class="text-danger"><strong>{{ $errors->first('home_banner_small_text') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">About Banner Text</label>
                            <textarea class="form-control" type="text" name="about_banner_text" id=""
                                placeholder="About Banner Text" id="">{{ @$setting->about_banner_text }}</textarea>
                            @if ($errors->has('about_banner_text'))
                            <span class="text-danger"><strong>{{ $errors->first('about_banner_text') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Service Banner Text</label>
                            <textarea class="form-control" type="text" name="service_banner_text" id=""
                                placeholder="Service Banner Text" id="">{{ @$setting->service_banner_text }}</textarea>
                            @if ($errors->has('service_banner_text'))
                            <span class="text-danger"><strong>{{ $errors->first('service_banner_text') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Home Page Our Mission Large Text</label>
                            <textarea class="form-control" type="text" name="homepage_our_mission_large_text" id=""
                                placeholder="Homepage Our Mission Large Text"
                                id="">{{ @$setting->homepage_our_mission_large_text }}</textarea>
                            @if ($errors->has('homepage_our_mission_large_text'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_mission_large_text')
                                    }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Page Our Mission Small Text</label>
                            <textarea class="form-control" type="text" name="homepage_our_mission_small_text" id=""
                                placeholder="Homepage Our Mission Small Text"
                                id="">{{ @$setting->homepage_our_mission_small_text }}</textarea>
                            @if ($errors->has('homepage_our_mission_small_text'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_mission_small_text')
                                    }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Page Our Mission Image</label>
                            <input class="form-control" type="file" name="homepage_our_mission_image">
                            @if ($errors->has('homepage_our_mission_image'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_mission_image')
                                    }}</strong> </span>
                            @endif
                        </div>

                        @if(isset($setting->homepage_our_mission_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->homepage_our_mission_image) }}"
                                alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Homepage Our Works Text</label>
                            <textarea class="form-control" type="text" name="homepage_our_works_text" id=""
                                placeholder="Homepage Our Works Text"
                                id="">{{ @$setting->homepage_our_works_text }}</textarea>
                            @if ($errors->has('homepage_our_works_text'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_works_text') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Page Our Vision Large Text</label>
                            <textarea class="form-control" type="text" name="homepage_our_vision_large_text" id=""
                                placeholder="Homepage Our Vision Large Text"
                                id="">{{ @$setting->homepage_our_mission_large_text }}</textarea>
                            @if ($errors->has('homepage_our_vision_large_text'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_vision_large_text')
                                    }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Page Our Vision Small Text</label>
                            <textarea class="form-control" type="text" name="homepage_our_vision_small_text" id=""
                                placeholder="Homepage Our Mission Small Text"
                                id="">{{ @$setting->homepage_our_vision_small_text }}</textarea>
                            @if ($errors->has('homepage_our_vision_small_text'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_vision_small_text')
                                    }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Home Page Our Vision Image</label>
                            <input class="form-control" type="file" name="homepage_our_vision_image">
                            @if ($errors->has('homepage_our_vision_image'))
                            <span class="text-danger"><strong>{{ $errors->first('homepage_our_vision_image')
                                    }}</strong> </span>
                            @endif
                        </div>

                        @if(isset($setting->homepage_our_vision_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->homepage_our_vision_image) }}"
                                alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Footer Text</label>
                            <textarea class="form-control" type="text" name="footer_text" id="footer_text"
                                placeholder="Footer Text" id="">{{ @$setting->footer_text }}</textarea>
                            @if ($errors->has('footer_text'))
                            <span class="text-danger"><strong>{{ $errors->first('footer_text') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Google Map Link</label>
                            <input class="form-control" type="text" name="google_map_link" id=""
                                placeholder="Google Map Link" value="{{ @$setting->google_map_link }}" id="">
                            @if ($errors->has('google_map_link'))
                            <span class="text-danger"><strong>{{ $errors->first('google_map_link') }}</strong> </span>
                            @endif
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Our Best Image</label>
                            <input class="form-control" type="file" name="our_best_image">
                            @if ($errors->has('our_best_image'))
                            <span class="text-danger"><strong>{{ $errors->first('our_best_image') }}</strong> </span>
                            @endif
                        </div>

                        @if(isset($setting->our_best_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->our_best_image) }}" alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Footer Image</label>
                            <input class="form-control" type="file" name="footer_image">
                            @if ($errors->has('footer_image'))
                            <span class="text-danger"><strong>{{ $errors->first('footer_image') }}</strong> </span>
                            @endif
                        </div>

                        @if(isset($setting->footer_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->footer_image ) }}" alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Room Page Background Image</label>
                            <input class="form-control" type="file" name="room_page_background_image">
                            @if ($errors->has('room_page_background_image'))
                            <span class="text-danger"><strong>{{ $errors->first('room_page_background_image')
                                    }}</strong> </span>
                            @endif
                        </div>

                        @if(isset($setting->room_page_background_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->room_page_background_image )}}"
                                alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Contact Page Background Image</label>
                            <input class="form-control" type="file" name="contact_page_bg_image">
                            @if ($errors->has('contact_page_bg_image'))
                            <span class="text-danger"><strong>{{ $errors->first('contact_page_bg_image') }}</strong>
                            </span>
                            @endif
                        </div>

                        @if(isset($setting->contact_page_bg_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->contact_page_bg_image)}}" alt="">
                        </div>
                        @endif


                        <div class="form-group mb-2">
                            <label class="form-label">Account Page Background Image</label>
                            <input class="form-control" type="file" name="account_page_bg_image">
                            @if ($errors->has('account_page_bg_image'))
                            <span class="text-danger"><strong>{{ $errors->first('account_page_bg_image') }}</strong>
                            </span>
                            @endif
                        </div>

                        @if(isset($setting->account_page_bg_image))
                        <div class="mb-3">
                            <img height="100px" width="100px" src="{{ url(@$setting->account_page_bg_image )}}" alt="">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label class="form-label">Contact Page Text</label>
                            <textarea class="form-control" type="text" name="contact_page_text"
                                placeholder="Our Best Text" id="">{{ @$setting->contact_page_text }}</textarea>
                            @if ($errors->has('contact_page_text'))
                            <span class="text-danger"><strong>{{ $errors->first('contact_page_text') }}</strong> </span>
                            @endif
                        </div>



                        <div class="form-actions mt-2">
                            <a href="{{ route('setting.show') }}">
                                <button type="button" class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel </button>
                            </a>
                            <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Update
                            </button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer.js')
<script>
    $(document).ready(function(){          
         
            CKEDITOR.replace( 'detail' ); 
                     
            CKEDITOR.replace( 'our_best_text');
            CKEDITOR.replace( 'footer_text');
            CKEDITOR.replace( 'contact_page_text' );
            // CKEDITOR.replace( 'companyName' );
        });      
</script>
@endsection