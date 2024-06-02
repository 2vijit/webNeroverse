@extends('layouts.app')
@section('title')
{{ 'Department' }}
@endsection
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
                    <li class="breadcrumb-item"><a href="">Department</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Add</a></li>
                </ol>
            </div>
            <h4 class="page-title">Create Department</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('department.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">

                        <div class="form-group mt-2">
                            <label>Title</label>
                            <input name="title" id="" class="form-control" placeholder="Title" required>
                            <span class="text-danger"> <b>{{ $errors->first('title') }}</b></span>
                        </div>

                        <div class="form-group mt-2">
                            <label>Description</label>
                            <textarea name="description" id="" class="form-control" placeholder="Description"
                                required></textarea>
                            <span class="text-danger"> <b>{{ $errors->first('description') }}</b></span>
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

                        <div class="multi-service">
                            <h3 class="text-center">Team Services</h3>
                            <div class="form-group mb-2">
                                <label class="form-label">Service Title</label>
                                <input type="text" class="form-control" placeholder="Service Title"
                                    value="{{ old('service_title') }}" name="service_title[]">
                                <span class="text-danger"> <b>{{ $errors->first('service_title') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Service Description</label>
                                <textarea type="text" class="form-control" placeholder="Service Description" value=""
                                    name="service_description[]">{{ old('service_description') }}</textarea>
                                <span class="text-danger"> <b>{{ $errors->first('service_description') }}</b></span>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Service Image</label>
                                <input type="file" class="form-control" name="service_image[]">
                                <span class="text-danger"> <b>{{ $errors->first('service_image') }}</b></span>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Service Status</label>
                                <select name="service_status[]" id="" class="form-control">
                                    <option value="">Select Service Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="text-danger"> <b>{{ $errors->first('service_status') }}</b></span>
                            </div>

                            <div class="col-md-12 text-center add_remove_button mb-3 mt-2">
                                <button class="btn btn-primary" id="add-button">+</button>
                                <button class="btn btn-danger" id="remove-button">-</button>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions mt-2">
                        <a href="{{ route('department.show') }}"><button type="button" class="btn btn-danger mr-1"><i
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
            const addButton = document.getElementById("add-button");
            const removeButton = document.getElementById("remove-button");
            addButton.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent form submission
                var newRow = `
       <div class="multi-service">
                            <div class="form-group mb-2">
                                <label class="form-label">Service Title</label>
                                <input type="text" class="form-control" placeholder="Service Title"
                                    value="{{ old('service_title') }}" name="service_title[]">
                                <span class="text-danger"> <b>{{ $errors->first('service_title') }}</b></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Service Description</label>
                                <textarea type="text" class="form-control" placeholder="Service Description" value=""
                                    name="service_description[]">{{ old('service_description') }}</textarea>
                                <span class="text-danger"> <b>{{ $errors->first('service_description') }}</b></span>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Service Image</label>
                                <input type="file" class="form-control" name="service_image[]">
                                <span class="text-danger"> <b>{{ $errors->first('service_image') }}</b></span>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label">Service Status</label>
                                <select name="service_status[]" id="" class="form-control">
                                    <option value="">Select Service Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="text-danger"> <b>{{ $errors->first('service_status') }}</b></span>
                            </div>                          
                        </div>
       `;
                var newRowContainer = document.createElement("div");
                newRowContainer.innerHTML = newRow;
                var addButtonContainer = document.querySelector('.add_remove_button');
                addButtonContainer.insertAdjacentElement("beforebegin", newRowContainer);
            });

            removeButton.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent form submission
                var packageItinerariesRow = document.querySelectorAll(".multi-service");
                if (packageItinerariesRow.length > 0) {
                    packageItinerariesRow[packageItinerariesRow.length - 1].remove();
                }
            });
        });
</script>
@endsection