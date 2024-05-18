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
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User Type</a></li>
                    </ol>
                </div>
                <h4 class="page-title">All User Type</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <a href="{{route('userType.create')}}" class="btn btn-md btn-info " ><i class="ft-plus"></i>Create New</a>
                    </div>
                    <table id="userTypeTable" class="table dt-responsive nowrap w-100"></table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
@endsection
@section('footer.js')
    <script>
        $(document).ready(function () {
            $('#userTypeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('userType.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{csrf_token()}}";
                    },
                },
                columns: [
                    {title: 'User Type ID', data: 'id', name: 'id', className: "text-center", orderable: true, searchable: true},
                    {title: 'User Type Name', data: 'type_name', name: 'type_name', className: "text-center", orderable: true, searchable: true},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.id + '" onclick="editUserType(this)"><i class="fa fa-edit"></i> Edit</a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.id + '" onclick="deleteUserType(this)"> Delete</a>'
                                ;
                        },
                        orderable: false, searchable: false
                    }
                ]
            });

        });

        function editUserType(x)
        {
            var btn = $(x).data('panel-id');
            var url = '{{route("userType.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteUserType(x)
        {
            var id = $(x).data('panel-id');
            if(!confirm("Delete This User Type?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('userType.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {
                    $('#userTypeTable').DataTable().clear().draw();
                    toastr.success('User Type Deleted Successfully');
                },
            });
        }
    </script>
@endsection
