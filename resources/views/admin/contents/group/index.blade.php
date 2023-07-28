@extends('admin.layouts.main')
@section('title', 'Group')

@section('stylesheet')

    <link href="{{asset('lib/bootstrap-toggle/bootstrap-toggle.min.css')}}" rel="stylesheet">

@endsection
@section('breadcumbs')
    @include('admin.templates.breadcrumbs')
@endsection
@section('content')
    <div class="row">

        <div class="col-sm-12">
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
                            <table id="groupTable" class="js-datatable table table-thead-bordered table-nowrap table-align-middle card-table table-striped table-hover" style="width:100%">
                                <thead class="thead-light">
                                    <tr class="table100-head">
                                        <th class="">#</th>
                                        <th class="">Name</th>
                                        <th class="">Code</th>
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

    @include('admin.contents.group._modal')
    @include('admin.contents.group._modal_access')

@endsection

@section('script')
    <script src="{{asset('lib/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>

    <script type="text/javascript">
        var url = {
            detail : "{{route('dashboard_group_detail')}}",
            delete : "{{route('dashboard_group_delete')}}",
            submit : "{{route('dashboard_group_post')}}",
            table : "{{route('dashboard_group_table')}}",
            access : "{{route('dashboard_group_menu_access')}}",
            change_access : "{{route('dashboard_group_change_access')}}"
        };
        var table, tbl_access;


        $(document).ready(function () {
            var CSRF_TOKEN = "{{@csrf_token()}}";
            table = $('#groupTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: url.table,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#', width: '2%'},
                    {data: 'name', name: 'name'},
                    {data: 'code', name: 'code'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center', width: '15%'},
                ]
            });

            //modal access
            $(document).on('click', '.access', function (e) {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let content = "";
                let table = "";
                e.preventDefault();
                $('#accessTable').dataTable().fnDestroy();


                tbl_access = $('#accessTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type : 'GET',
                        url : url.access,
                        data : {
                            group_id : id
                        }
                    } ,
                    "fnDrawCallback": function() {
                        $('.toggle-demo').bootstrapToggle();
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#', width: '1%', className: 'dt-center'},
                        {data: 'name', name: 'name'},
                        // {data: 'access_data.is_viewable', name: 'name', defaultContent: '-'},
                        {data: 'parent.name', name: 'parent', defaultContent: "-"},
                        {data: 'code', name: 'code'},
                        {
                            data: null, name: 'is_viewable', className: 'dt-center', render: function (data) {
                                return `<input class="toggle-demo cb" data-type="is_viewable" data-id="${data.access_data.id}" id="viewableSw${data.access_data.id}" type="checkbox" ${(data.access_data.is_viewable == true ? 'checked' : '')} data-toggle="toggle" data-onstyle="success" data-offstyle="danger">`;
                            }
                        },
                        {
                            data: null, name: 'is_addable', className: 'dt-center', render: function (data) {
                                return `<input class="toggle-demo cb" data-type="is_addable"  data-id="${data.access_data.id}" id="addableSw${data.access_data.id}" type="checkbox" ${(data.access_data.is_addable == true ? 'checked' : '')} data-toggle="toggle" data-onstyle="success" data-offstyle="danger">`
                            }
                        },
                        {
                            data: null, name: 'is_editable', className: 'dt-center', render: function (data) {
                                return `<input class="toggle-demo cb" data-type="is_editable" data-id="${data.access_data.id}" id="updatbleSw${data.access_data.id}" type="checkbox" ${(data.access_data.is_editable == true ? 'checked' : '')} data-toggle="toggle" data-onstyle="success" data-offstyle="danger">`;
                            }
                        },
                        {
                            data: null, name: 'is_deletable', className: 'dt-center', render: function (data) {
                                return `<input class="toggle-demo cb" data-type="is_deletable" data-id="${data.access_data.id}" id="deletable${data.access_data.id}" type="checkbox" ${(data.access_data.is_deletable == true ? 'checked' : '')} data-toggle="toggle" data-onstyle="success" data-offstyle="danger">`;
                            }
                        },
                    ]
                });
                modalShow('accessModal',`Access Data ${name}`);
            });

            //update access
            $(document).on('change','.cb', function (e){
                let type = $(this).data('type')

                let params = {
                    'pivot_id' : $(this).data('id'),
                    'type' : type,
                    'value' : ($(this).prop("checked") == true ? 1 : 0)
                }
                $.get(url.change_access, {params : params}, function (result){
                    swalStatus(result,"myModal", false)
                });
            })

            $(document).on('click', '.view', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formDisable();
                modalShow('myModal','View Data');
                $.get(url.detail, {id : id}, function (result){
                    let response = result.data;

                    $('#name').val(response.name)
                    $('#code').val(response.code)
                });

            });

            $(document).on('click', '.update', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formEnable();
                modalShow('myModal','Update Data');

                $.get(url.detail,{id : id}, function (result){
                    let response = result.data;
                    $('#id').val(response.id)
                    $('#name').val(response.name)
                    $('#code').val(response.code)
                });

            });
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                Swal.fire({
                    title: `Are you sure delete ${$(this).data('name')}?`,
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url.delete,
                            method: 'GET',
                            data: {
                                id: $(this).data('id'),
                            },
                        })
                            .then((result) => {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: result.success,
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000,
                                })
                            }).then(() => {
                            tableReload(table)
                        });
                    }
                });
            });


            $('#formModal').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true,
                    },
                    code: {
                        required: true,
                    }

                },
                submitHandler: function (form) {
                    let data = $('#formModal').serialize();

                    $.post(url.submit, data, function (result) {
                        swalStatus(result, "myModal", '', table)
                    });
                }
            });


        });
    </script>

@endsection
