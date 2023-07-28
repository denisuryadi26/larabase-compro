@extends('admin.layouts.main')
@section('title', 'Team')

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}">
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
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>

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
@include('admin.contents.team._modal')
@endsection

@section('script')

<script src="{{asset('lib/bootstrap-fileinput/js/fileinput.js')}}"></script>
<script src="{{asset('lib/fa-theme/theme.js')}}"></script>
<script type="text/javascript">
    var url = {
        detail: "{{route('dashboard_teams_detail')}}",
        delete: "{{route('dashboard_teams_delete')}}",
        submit: "{{route('dashboard_teams_post')}}",
        table: "{{route('dashboard_teams_table')}}"
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: "image",
                    className: 'dt-center',
                    "render": function(data, type, row) {
                        let img = "{{asset('storage/images/')}}" + '/' + `${data}`;
                        return `<img src="${img}" class="img-thumbnail img-responsive" style="max-width: 150px; max-height: 150px" />`;
                    }
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

        $('.addModal').on('click', function() {
            resetFileInput();
            makeInput();
            formReset(true);
            $(".modal").removeAttr("tabindex");

            modalShow('myModal', 'Add Data');
        });

        $(document).on('click', '.view', function(e) {
            let id = $(this).data('id');
            e.preventDefault();
            formDisable();
            modalShow('myModal', 'View Data');
            $.get(url.detail, {
                id: id
            }, function(result) {

                let response = result.data;
                $('#title').val(response.title)
                $('#description').val(response.description)
                // $('#image').val(response.image)
                makeInput(response.image)


            });

        });

        $(document).on('click', '.update', function(e) {
            let id = $(this).data('id');
            e.preventDefault();
            formEnable();
            modalShow('myModal', 'Update Data');

            $.get(url.detail, {
                id: id
            }, function(result) {
                let response = result.data;
                $('#id').val(response.id)
                $('#title').val(response.title)
                $('#description').val(response.description)
                // $('#image').val(response.image)
                makeInput(response.image)


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
                            swalStatus(result, "myModal")
                        }).then(() => {
                            tableReload(table)
                        });
                }
            });
        });


        $('#formModal').validate({ // initialize the plugin
            rules: {
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                image: {
                    required: true,
                },


            },
            submitHandler: function(form) {
                // let data = $('#formModal').serialize();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                let id = $('#id').val();


                let file_data = $('#fileUpload').prop('files')[0],
                    form_data = new FormData(document.getElementById('formModal'));

                form_data.append('_token', $("input[name=_token]").val());
                // form_data.append('_cache_id' , localStorage.getItem('cache_id'));
                form_data.append('image', file_data);
                form_data.append('id', id);


                $.ajax({
                    url: url.submit,
                    data: form_data,
                    type: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swalStatus(response, "myModal", '', table)

                    }

                });
                event.preventDefault();

                // $.post(url.submit, data, function(result) {
                //     swalStatus(result, "myModal", '', table)
                // });
            }
        });

        function resetFileInput() {
            $('#fileUpload').fileinput('destroy');
        }

        function makeInput(value) {
            $('#fileUpload').fileinput('destroy');

            if (value) {
                let url = "{{asset('storage/images/')}}" + '/' + `${value}`
                let filename = value.split('/')[1];
                $("#fileUpload").fileinput({
                    'showUpload': false,
                    theme: 'fa',
                    showClose: false,
                    showMove: false,
                    initialPreviewConfig: [{
                        caption: `${filename}`,
                        downloadUrl: url,
                        key: 1
                    }],
                    initialPreview: url,
                    initialPreviewAsData: true,
                    layoutTemplates: {
                        progress: '',
                        remove: ''
                    },
                    allowedFileExtensions: ["jpg", "png", "gif"],
                    initialPreviewShowDelete: false,
                    //{{--deleteUrl: '{{route('file_delete')}}',--}}
                    elErrorContainer: '#kartik-file-errors',
                });

                $(".glyphicon").removeClass("glyphicon-download").removeClass('glyphicon').addClass('fa fa-download');

            } else {
                $("#fileUpload").fileinput({
                    'showUpload': false,
                    theme: 'fa',
                    'previewFileType': 'any',
                    fileActionSettings: {
                        showDrag: false,
                    },
                    allowedFileExtensions: ['jpg', 'gif', 'png', 'jpeg'],
                    initialPreviewAsData: true,
                    layoutTemplates: {
                        progress: '',
                        remove: ''
                    },
                    initialPreviewShowDelete: true
                        //, deleteUrl: '{{route('file_delete')}}'
                        ,
                    elErrorContainer: '#kartik-file-errors',
                });
            }
        }

    });
</script>


@endsection