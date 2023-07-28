@extends('admin.layouts.main')

@section('stylesheet')

@endsection

@section('breadcumbs')
    @include('admin.templates.breadcrumbs')
@endsection

@section('content')
    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">{{$menu['breadcrumbs']->name}} Table</h4>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $current_path = \Request::route()->getName();
                                    getPagesAccess($current_path);
                                @endphp
                            </div>
                        </div>
                    </div>


                    <div class="card-content">
                        <div class="card-body">

                            <div class="card-datatable table-responsive">
                                <table id="contentTable" class="js-datatable table table-thead-bordered table-nowrap table-align-middle card-table table-striped table-hover" style="width:100%">
                                    <thead class="thead-light">
                                    <tr class="table100-head">
                                        <th width="3%" class="text-center">No</th>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>SIP</th>
                                        <th>Group</th>
                                        <th class="text-center">Action</th>
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

@endsection

@section('script')

@endsection

