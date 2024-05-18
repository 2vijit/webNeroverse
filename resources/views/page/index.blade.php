@extends('layouts.app')
@section('title'){{ 'Page' }}@endsection
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
                            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pages</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            <a href="{{ route('page.create') }}" class="btn btn-md btn-info " ><i class="ft-plus"></i>Create New</a>
                        </div>
                        <table id="pageTable" class="table dt-responsive nowrap w-100"></table>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>

   
@endsection
@section('footer.js')
    <script>
        $(document).ready(function () {
            $('#pageTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('page.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Page Title', data: 'pageTitle', name: 'pageTitle', className: "text-center", orderable: true, searchable: true},
                    {title: 'Image', data: 'image', name: 'image', className: "text-center", orderable: false, searchable: false},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.pageId + '" onclick="editPage(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.pageId + '" onclick="deletePage(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editPage(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("page.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deletePage(x) {
            let pageId = $(x).data('panel-id');
            if(!confirm("Delete This Page? This will also delete related menu.")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('page.delete') !!}",
                cache: false,
                data: {_token: "{{ csrf_token() }}",'pageId': pageId},
                success: function (data) {
                    toastr.success('Page Deleted Successfully!');
                    $('#pageTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
