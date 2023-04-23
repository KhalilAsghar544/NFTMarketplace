@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'nft_settings'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Settings')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="user-management card">
        <div class="row">
            <div class="col-12">
                @include('user.message')
                <ul class="nav nav-tabs mb-3 user-page-tab-list user-management-tab-list" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='moralis') active @endif nav-link " id="pills-user-tab"
                           data-toggle="pill" data-controls="general" href="#general" role="tab"
                           aria-controls="pills-user" aria-selected="true">
                            <i class="fas fa-cogs"></i><span>{{__('Moralis Settings')}}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show @if(isset($tab) && $tab=='moralis')  active @endif" id="general"
                         role="tabpanel" aria-labelledby="pills-user-tab">
                        <div class="header-bar">
                            <div class="table-title">
                                <h3>{{__('NFT Settings')}}</h3>
                            </div>
                        </div>
                        <div class="profile-info-form">
                            <form action="{{route('admin_moralis_update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Moralis Server URL')}}</label>
                                            <input class="form-control" type="text" name="moralis_server_url"
                                                   placeholder="{{__('Moralis Server URL')}}"
                                                   value="{{env('MORALIS_SERVER_URL')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12  mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Moralis Application ID')}}</label>
                                            <input class="form-control" type="text" name="moralis_application_id"
                                                   placeholder="{{__('Moralis Application ID')}}"
                                                   value="{{env('MORALIS_APPLICATION_ID')}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label
                                                for="#">{{__('Contract Address')}} </label>
                                            <input class="form-control number_only" type="text"
                                                   name="contact_address" placeholder="{{__('Contract Address')}}"
                                                   value="{{env('CONTRACT_ADDRESS')}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label
                                                for="#">{{__('Admin Address')}} </label>
                                            <input class="form-control number_only" type="text"
                                                   name="admin_address" placeholder="{{__('Admin Address')}}"
                                                   value="{{env('ADMIN_ADDRESS')}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label
                                                for="#">{{__('Fee (Percentage)')}} </label>
                                            <input class="form-control number_only" type="number" min="0" step="0.01"
                                                   name="fee_percent" placeholder="{{__('Fee (Percentage)')}}"
                                                   value="{{env('FEE_PERCENT')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label
                                                for="#">{{__('Chain')}} </label>
                                            <input class="form-control " type="text"
                                                   name="chain" placeholder="{{__('Chain)')}}"
                                                   value="{{env('CHAIN')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label
                                                for="#">{{__('Explorer URL')}} </label>
                                            <input class="form-control " type="text"
                                                   name="explorer_url" placeholder="{{__('Explorer URL)')}}"
                                                   value="{{env('EXPLORER_URL')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(isset($itech))
                                        <input type="hidden" name="itech" value="{{$itech}}">
                                    @endif
                                    <div class="col-lg-2 col-12 mt-20">
                                        <button class="btn btn-info mt-2">{{__('Update')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/settings/general.js')}}"></script>
@endsection
