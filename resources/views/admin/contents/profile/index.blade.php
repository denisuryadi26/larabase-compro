@extends('admin.layouts.main')
@section('title', 'Profile')

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}">
@endsection

@section('breadcumbs')
@include('admin.templates.breadcrumbs')
@endsection

@section('content')
<section id="configuration">
    <div class="row">
        <div class="col-md-12 col-lg-12">

            <div class="card">

                <div class="row">
                    <div class="col-xl-12 col-lg-8 col-md-7">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                        <div class="user-avatar-section">
                                            <div class="d-flex justify-content-start">
                                                <img class="img-fluid rounded" src="{{ Auth::user()->profile_picture ? asset('storage/images/'.Auth::user()->profile_picture) : asset('datta-able/assets/images/user/avatar-4.jpg')}}" height="104" width="104" alt="User avatar" />
                                                <div class="d-flex flex-column ml-1">
                                                    <div class="user-info mb-1">
                                                        <h4 class="mb-0">{{$profile->fullname}}</h4>
                                                        <span class="card-text">{{$profile->email}}</span>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <!-- <input type="button" data-profile="{{$profile->profile_picture}}" class="btn btn-primary" id="btnProfile" value="Edit Profile" /> -->
                                                        <button type="button" data-profile="{{$profile->profile_picture}}" class="btn btn-primary" id="btnProfile" value="Edit Profile">Edit Profile</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                        <div class="user-info-wrapper">
                                            <div class="d-flex flex-wrap">
                                                <div class="user-info-title">
                                                    <i data-feather="user" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">Username :</span>
                                                </div>
                                                &nbsp;<p class="card-text mb-0">{{$profile->username}}</p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="check" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">Status :</span>
                                                </div>
                                                &nbsp;<p class="card-text mb-0">Active</p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="star" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">Group :</span>
                                                </div>
                                                &nbsp;<p class="card-text mb-0">{{$profile->group->name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('admin.contents.profile._modal')
@endsection

@section('script')

<script src="{{asset('lib/bootstrap-fileinput/js/fileinput.js')}}"></script>
<script src="{{asset('lib/fa-theme/theme.js')}}"></script>
<script type="text/javascript">
    var url = {
        submit: "{{route('dashboard_profile_post')}}"
    };
    var table, tbl_access;

    $(document).ready(function() {
        var CSRF_TOKEN = "{{@csrf_token()}}";

        $('#confirm_password').on('keyup', function() {
            let confrim = $(this).val(),
                password = $('#password').val();
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


        $(document).on('click', '#btnProfile', function(e) {
            let pp = $(this).data('profile');
            makeInput(pp)
            modalShow('myModal', 'Update Data');
        });

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
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                }

            },
            submitHandler: function(form) {

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
                form_data.append('fileUpload', file_data);
                form_data.append('id', id);


                $.ajax({
                    url: url.submit,
                    data: form_data,
                    type: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swalStatus(response, "myModal")
                        window.location.reload();
                    }
                });
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