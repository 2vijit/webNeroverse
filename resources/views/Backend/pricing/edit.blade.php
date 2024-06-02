@extends('layouts.app')
@section('title'){{ 'Department Update' }}@endsection
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
                    <li class="breadcrumb-item"><a href="{{ route('department.show') }}">Department</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                </ol>
            </div>
            <h4 class="page-title">Edit Department</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('department.update', $works->id) }}" method="POST"
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
                        <hr>
                        @foreach ($service as $services)
                        <div class="multi-service">
                            <div id="service{{ $services->id }}">
                                <h3 class="text-center">Service</h3>
                                <div class="form-group mb-2">
                                    <label class="form-label">Service Title</label>
                                    <input type="text" class="form-control" placeholder="Service Title"
                                        value="{{ @$services->title }}" name="service_title[]">
                                    <input type="hidden" value="{{ $services->id }}" name="service_id[]">
                                    <span class="text-danger"> <b>{{ $errors->first('service_title') }}</b></span>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Service Description</label>
                                    <textarea type="text" class="form-control" placeholder="Service Description"
                                        value="" name="service_description[]">{{ @$services->description }}</textarea>
                                    <span class="text-danger"> <b>{{ $errors->first('service_description') }}</b></span>
                                </div>


                                <div class="form-group mb-2">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control mb-3" name="image[]">
                                    <span class="text-danger"> <b>{{ $errors->first('image') }}</b></span>
                                    @if(isset($services->image))
                                    <img height="50px" width="50px" src="{{url('public/service/'.$services->image)}}"
                                        alt="">
                                    @endif
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Status</label>
                                    <select name="service_status[]" id="" class="form-control">
                                        <option value="">Select Serice Status</option>
                                        <option value="active" @if($services->status == 'active') selected @endif>Active
                                        </option>
                                        <option value="inactive" @if($services->status == 'inactive') selected
                                            @endif>Inactive</option>
                                    </select>
                                    <span class="text-danger"> <b>{{ $errors->first('service_staus') }}</b></span>
                                </div>

                                <div class="form-group mb-2">
                                    <a title="delete" class="btn btn-danger btn-xs" style="margin-top: 40px"
                                        onclick="deleteFood({{ $services->id }})">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                        @endforeach
                        <div class="col-md-12 text-center add_remove_button mb-3 mt-2">
                            <button class="btn btn-primary" id="add-button">+</button>
                            <button class="btn btn-danger" id="remove-button">-</button>
                        </div>

                        <div class="form-actions mb-2">
                            <a href="{{ route('department.show') }}"><button type="button"
                                    class="btn btn-danger mr-1"><i class="ft-x"></i> Cancel</button></a>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
   const addButton = document.getElementById("add-button");
   const removeButton = document.getElementById("remove-button");
   addButton.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent form submission
       var newRow = `
       <div class="multi-service">
       <div class="form-group mb-2">
        <label class="form-label">Service Title</label>
        <input type="text" class="form-control" placeholder="Service" value="{{ old('extra_service_title') }}" name="extra_service_title[]">
        <span class="text-danger"> <b>{{  $errors->first('extra_service_title') }}</b></span>
        </div>
      
        <div class="form-group mb-2">
        <label class="form-label">Service Description</label>
        <textarea class="form-control" name="extra_service_description[]" id="detail" cols="10" rows="1"></textarea>
        <span class="text-danger"> <b>{{  $errors->first('extra_service_description') }}</b></span>
        </div>

        <div class="form-group mb-2">
        <label class="form-label">Service Image</label>
        <input type="file" class="form-control" name="extra_service_image[]">
        <span class="text-danger"> <b>{{  $errors->first('extra_service_image') }}</b></span>
        </div>

        <div class="form-group mb-2">
        <label class="form-label">Service Status</label>
        <select name="extra_service_status[]" id="" class="form-control">
            <option value="">Select status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <span class="text-danger"> <b>{{  $errors->first('extra_service_status') }}</b></span>
        </div>
        </div>
       `;
       var newRowContainer = document.createElement("div");
       newRowContainer.innerHTML = newRow;
       var addButtonContainer = document.querySelector('.add_remove_button');
       addButtonContainer.insertAdjacentElement("beforebegin", newRowContainer);
   });

   removeButton.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent form submission
       var packageItinerariesRow = document.querySelectorAll(".multi-service");
       if (packageItinerariesRow.length > 0) {               
           packageItinerariesRow[packageItinerariesRow.length - 1].remove();
       }
   });
    });

    function deleteFood(id) {
        serviceId = id;
        $.ajax({
            type: 'POST',
            url: "{{ route('service.delete') }}",
            data: {'serviceId': serviceId, _token: "{{ csrf_token()}}"},
            success: function (data) {
                toastr.success('Service Deleted Successfully');
                $('#service' + id).remove();
            }
        });
    }    
</script>
@endsection