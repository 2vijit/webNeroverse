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
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Team</a></li>
                    </ol>
                </div>
                <h4 class="page-title">All Team Members</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <a href="{{ route('team.create') }}" class="btn btn-md btn-info " ><i class="ft-plus"></i>Create New</a>
                    </div>
                    <table id="teamTable" class="table dt-responsive nowrap w-100"></table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
@endsection
@section('footer.js')
    <script>
        $(document).ready(function () {
            $('#teamTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('team.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{csrf_token()}}";
                    },
                },
                columns: [
                    {title: 'Name', data: 'name', name: 'name', className: "text-center", orderable: true, searchable: true},
                    {title: 'Email', data: 'mail', name: 'mail', className: "text-center", orderable: true, searchable: true},
                    {title: 'Image', data: 'image', name: 'image', className: "text-center", orderable: false, searchable: false},
                    {title: 'Designation', data: 'designation', name: 'designation', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.id + '" onclick="editTeam(this)"><i class="fas fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.id + '" onclick="deleteTeam(this)"><i class="fas fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editTeam(x) {
            var btn = $(x).data('panel-id');
            var url = '{{route("team.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteTeam(x) {
            var id = $(x).data('panel-id');
            if(!confirm("Delete This Team Member?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('team.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {
                    toastr.success('Team Member Deleted Successfully');
                    $('#teamTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
