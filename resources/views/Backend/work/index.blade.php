@extends('layouts.app')
@section('title'){{ 'Department' }}@endsection
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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Department</a></li>
                </ol>
            </div>
            <h4 class="page-title">All Department</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    <a href="{{ route('department.create') }}" class="btn btn-md btn-info "><i
                            class="ft-plus"></i>Create
                        New</a>
                </div>
                <table id="departmentTable" class="table dt-responsive nowrap w-100"></table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@endsection
@section('footer.js')
<script>
    $(document).ready(function () {
            $('#departmentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('department.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{csrf_token()}}";
                    },
                },
                columns: [
                    {title: 'Title', data: 'title', name: 'title', className: "text-center", orderable: true, searchable: true},
                    {title: 'Description', data: 'description', name: 'description', className: "text-center", orderable: false, searchable: false}, 
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: false, searchable: false},                 
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.id + '" onclick="editDepartment(this)"><i class="fas fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.id + '" onclick="deleteDepartment(this)"><i class="fas fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editDepartment(x) {
            var btn = $(x).data('panel-id');
            var url = '{{route("department.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteDepartment(x) {
            var id = $(x).data('panel-id');
            if(!confirm("Delete Department?")){
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "{!! route('department.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {
                    toastr.success('Department Deleted Successfully');
                    $('#departmentTable').DataTable().clear().draw();
                },
            });
        }
</script>
@endsection