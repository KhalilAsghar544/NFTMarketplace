@extends('admin.master',['menu'=>'service-transaction', 'sub_menu' => 'all-transactions'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Transactions (Buy-Sell)')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Transactions')}}</a></li>
                        <li class="breadcrumb-item active">{{__('All Transactions')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('user.message')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__("All Transactions")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="all">{{__('from')}}</th>
                                        <th scope="col" class="all">{{__('to')}}</th>
                                        <th scope="col" class="all">{{__('amount')}}</th>
                                        <th scope="col" class="all">{{__('type')}}</th>
                                        <th scope="col" class="all">{{__('token address')}}</th>
                                        <th scope="col" class="all">{{__('token id')}}</th>
                                        <th scope="col" class="all">{{__('Transaction Time')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="table-url" data-url="{{route('admin_all_transaction')}}"></div>
@endsection
@section('script')
    <script>
        (function ($) {
            "use strict";
            $('#table').DataTable({
                processing: true,
                pageLength: 10,
                ajax: '{{route('admin_all_transaction')}}',
                order:[0,'asc'],
                autoWidth: false,
                language: {
                    paginate: {
                        next: 'Next &#8250;',
                        previous: '&#8249; Previous'
                    }
                },
                columns: [
                    {"data": "from_address",'name':'from_address'},
                    {"data": "to_address",'name':'to_address'},
                    {"data": "amount",'name':'amount'},
                    {"data": "type",'name':'type'},
                    {"data": "token_address",'name':'token_address'},
                    {"data": "token_id",'name':'token_id'},
                    {"data": "time",'name':'time'},
                ]
            });
        })(jQuery)

    </script>
@endsection
