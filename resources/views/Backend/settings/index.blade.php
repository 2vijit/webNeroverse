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
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                </ol>
            </div>
            <h4 class="page-title">All Settings</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(empty($setting))
                <div class="text-end mb-3">
                    <a href="{{ route('setting.create') }}" class="btn btn-md btn-info "><i class="ft-plus"></i>Create
                        New</a>
                </div>
                @endif
                <table id="settingTable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class='text-center'>Company Name</th>
                            <th class='text-center'>Email</th>
                            <th class='text-center'>Phone</th>
                            <th class='text-center'>Company Logo 1</th>
                            <th class='text-center'>Company Logo 2</th>
                            <th class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($setting))
                        <tr>
                            <td class='text-center'>
                                <span class="tabledit-span">{{ @$setting->companyName }}</span>
                            </td>
                            <td class='text-center'>
                                <span class="tabledit-span">{{ @$setting->email }}</span>
                            </td>
                            <td class='text-center'>
                                <span class="tabledit-span">{{ @$setting->phone }}</span>
                            </td>
                            <td class='text-center'>
                                <span class="tabledit-span">
                                    <img height="30" width="50" class="img-rounded"
                                        src="{{ url(@$setting->logo_1 ?? "") }}" alt="{{ @$setting->logo_1_alt_tag }}">
                                </span>
                            </td>
                            <td class='text-center'>
                                <span class="tabledit-span">
                                    <img height="30" width="50" class="img-rounded"
                                        src="{{ url(@$setting->logo_2 ?? "") }}" alt="{{ @$setting->logo_2_alt_tag }}">
                                </span>
                            </td>
                            <td class='text-center'>
                                <a class="btn btn-warning btn-sm" href="{{route('setting.edit', @$setting->id)}}"><i
                                        class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="6" class="text-center">No Content</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@endsection
@section('footer.js')
<script>

</script>
@endsection