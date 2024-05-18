@extends('layouts.app')
@section('title'){{ 'Menu' }}@endsection
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                    </ol>
                </div>
                <h4 class="page-title">All Menu</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <a href="{{ route('menu.create') }}" class="btn btn-md btn-info " ><i class="ft-plus"></i>Create New</a>
                    </div>
                    <table id="menuTable" class="table dt-responsive nowrap w-100"></table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
@endsection
@section('footer.js')
    <script>
        $(document).ready(function () {
            $('#menuTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('menu.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Menu Name', data: 'menuName', name: 'menuName', className: "text-center", orderable: true, searchable: true},
                    
                    {title: 'Menu Order', data: 'menuOrder', name: 'menuOrder', className: "text-center", orderable: true, searchable: true},
                    {title: 'Menu Type', data: 'menuType', name: 'menuType', className: "text-center", orderable: true, searchable: true},                  
                    {title: 'Page Title', data: 'fkPageId', name: 'fkPageId', className: "text-center", orderable: false, searchable: false},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.menuId + '" onclick="editMenu(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.menuId + '" onclick="deleteMenu(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editMenu(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("menu.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteMenu(x) {
            let menuId = $(x).data('panel-id');
            if(!confirm("Delete This Menu? This will also delete Sub Menus.")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('menu.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'menuId': menuId},
                success: function (data) {
                    toastr.success('Menu Deleted Successfully!');
                    $('#menuTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
