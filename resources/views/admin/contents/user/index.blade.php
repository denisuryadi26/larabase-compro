@extends('admin.layouts.main')
@section('title', 'User')

@section('stylesheet')
@endsection
@section('breadcumbs')
@include('admin.templates.breadcrumbs')
@endsection
@section('content')
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
                            <th>Username</th>
                            <th>Fullname</th>
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
<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{$menu['breadcrumbs']->name}} Table</h4>
                <p class="text-muted font-13 mb-4">
                    @php
                    $current_path = \Request::route()->getName();
                    getPagesAccess($current_path);
                    @endphp
                </p>

                <table id="contentTable" class="table dt-responsive nowrap w-100">
                    <thead class="thead-light">
                        <tr class="table100-head">
                            <th width="3%" class="text-center">No</th>
                            <th>Username</th>
                            <th>Fullname</th>
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
</div> -->
@include('admin.contents.user._modal')

@endsection


@section('script')


<!-- BEGIN: Page JS-->


<script type="text/javascript">
    var url = {
        detail: "{{route('dashboard_user_detail')}}",
        delete: "{{route('dashboard_user_delete')}}",
        submit: "{{route('dashboard_user_post')}}",
        table: "{{route('dashboard_user_table')}}"
    };
    var table;


    $(document).ready(function() {
        var CSRF_TOKEN = "{{@csrf_token()}}";
        table = $('#contentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: url.table,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    title: '#',
                    width: '2%'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'fullname',
                    name: 'fullname'
                },
                // {data: 'email', name: 'email'},
                {
                    data: 'group.name',
                    name: 'group'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '15%'
                },
            ]
        });

        $(document).on('click', '.view', function(e) {
            let id = $(this).data('id');
            e.preventDefault();
            formReset(true);
            formDisable();

            modalShow('myModal', 'View Data');
            $.get(url.detail, {
                id: id
            }, function(result) {

                let response = result.data;
                // $('#fullname').val(response.fullname)
                if (response.employee) $('#employee_id').val(response.employee.id).trigger('change')
                $('#username').val(response.username)
                $('#fullname').val(response.fullname)
                $('#sip').val(response.sip)
                $('#email').val(response.email)
                $('#group').val(response.group.id).trigger('change')
            });

        });

        $(document).on('click', '.update', function(e) {
            let id = $(this).data('id');
            e.preventDefault();
            formReset(true);
            formEnable();
            modalShow('myModal', 'Update Data');
            $.get(url.detail, {
                id: id
            }, function(result) {
                let response = result.data;
                $('#id').val(response.id)
                if (response.employee) $('#employee_id').val(response.employee.id).trigger('change')
                $('#username').val(response.username)
                $('#fullname').val(response.fullname)
                $('#sip').val(response.sip)
                $('#email').val(response.email)

                $('#group').val(response.group.id).trigger('change')
            });

        });

        $(document).on('click', '.delete', function(e) {
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

        $('#confirm_password').on('keyup', function() {
            let confrim = $(this).val(),
                password = $('#password').val();

            console.log(confrim, password)

            if (password != confrim) {
                $('.invalid').removeAttr('hidden')
                $('#btn-submit').attr('hidden', true)
                // $("#btn-submit").attr('class', 'btn btn-block');

            } else {
                $('.invalid').attr('hidden', true)
                $('#btn-submit').removeAttr('hidden')
                // $("#btn-submit").attr('class', 'btn btn-outline-info');
            }
        });


        $(document).on('click', '#formSubmit', function() {
            $('#formModal').submit();
        })


        $('#formModal').validate({ // initialize the plugin
            rules: {
                username: {
                    required: true,
                },
                fullname: {
                    required: true,
                },
                email: {
                    required: true,
                },
                group_id: {
                    required: true,
                }

            },
            submitHandler: function(form) {
                let data = $('#formModal').serialize();

                $.post(url.submit, data, function(result) {
                    swalStatus(result, "myModal", '', table)
                });
            }
        });

    });
</script>

@endsection