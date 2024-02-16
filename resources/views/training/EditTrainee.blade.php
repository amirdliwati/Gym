@extends('layouts.app')
@section('css')
    <title>{{__('Modifiy Trainee')}}</title>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
    <h3>{{__('Modifiy Trainee')}}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
        <li class="breadcrumb-item">{{ Auth::user()->roles->first()->blug }}</li>
        <li class="breadcrumb-item active">{{__('Modifiy Trainee')}}</li>
    </ol>
@endsection
@section('bookmark')
    <li><button type="button" class="btn-sm btn-pill btn-outline-primary" onclick="RefreshPage()"><i data-feather="refresh-cw"></i></button></li>
@endsection
@section('content')
<!-- Page Content-->
<form id="form" enctype="multipart/form-data" data-parsley-required-message="">
    @csrf
    <input type="hidden" id="Trainee_id" name="Trainee_id" value="{{$Trainee->id}}">
    <div class="card">
        <div class="card-header b-l-warning border-3"><h5> {{__('Modifiy Trainee')}} ({{$Trainee->first_name}} {{$Trainee->last_name}})</h5> @include('layouts/button_card') </div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item btn-round">
                    <a class="nav-link active" id="Personal-tab" data-toggle="pill" href="#Personal" aria-selected="true"><i class="fa fa-user"></i><b id="apers"></b>{{__('Personal')}}</a>
                </li>
                <li class="nav-item btn-round">
                    <a class="nav-link" id="Contact-tab" data-toggle="pill" href="#Contact" aria-selected="false"><i class="fa fa-address-book"></i><b id="acont"></b>{{__('Contact')}}</a>
                </li>
                <li class="nav-item btn-round">
                    <a class="nav-link" id="Finish-tab" data-toggle="pill" href="#Finish"  aria-selected="false"><i class="fa fa-flag-checkered"></i><b id="ajobs"></b>{{__('Finish')}}</a>
                </li>
            </ul>
            <div class="tab-content mt-4" id="pills-tabContent">

                <div class="tab-pane fade show active" id="Personal">
                    @include('training/EditTrainee/PersonalE')
                </div><!-- end Personal step-1 -->

                <div class="tab-pane fade mt-4" id="Contact">
                    @include('training/EditTrainee/PhonesE')
                    @include('training/EditTrainee/MailsE')
                </div><!-- /.Contact -->

                <div class="tab-pane fade mt-4" id="Finish">
                    @include('training/EditTrainee/AddressE')
                    @include('training/EditTrainee/EmergencyE')
                </div><!-- /.Finish -->

            </div><!-- /.tab-content -->
        </div><!--end card-body-->
        <div class="card-footer">
            <button id="finish" form="form" data-action="save-png" type="submit" class="btn btn-success-gradien btn-pill"><i class="mdi mdi-content-save-all mr-1"></i>{{__('Save')}}</button>
            <a href="{{route('Trainees')}}"><button type="button" class="btn btn-warning-gradien btn-pill"><i class="mdi mdi-backup-restore mr-1"></i>{{__('Back To Trainees')}}</button></a>
        </div>
    </div><!--end card-->
</form>
@endsection
@section('javascript')
    <!-- Plugins js -->
    <script src="{{ asset('js/moment/moment.js') }}"></script>
    <script src="{{ asset('js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('js/touchspin/touchspin.js') }}"></script>
    <script src="{{ asset('js/parsleyjs/parsley.min.js') }}"></script>

    <!-- Form Wizard -->
    <script src="{{ asset('js/form-wizard/form-wizard-three.js') }}"></script>
    <script src="{{ asset('js/form-wizard/jquery.backstretch.min.js') }}"></script>

    <!-- Files Upload -->
    <script src="{{ asset('libs/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('libs/dropify/js/jquery.form-upload.init.js') }}"></script>

    <!-- Repeater -->
    <script src="{{ asset('js/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('js/repeater/jquery.form-repeater.js') }}"></script>

    <!-- Other Scripts -->
    <script type="text/javascript">
        $('form').parsley();
        $('.mx').maxlength({warningClass: "badge badge-info",limitReachedClass: "badge badge-warning",alwaysShow :true});
        $('.datem').datepicker({language: 'en', autoClose: true, dateFormat: 'yyyy-mm-dd' });
        $(".select2").select2({width: '100%', placeholder: 'Select an option'});

        $( ".select2" ).change(function() {
            if ($(this).val() == "") { $(this).siblings(".select2-container").css({'border': '1px solid red','border-radius': '5px'}); }
            else { $(this).siblings(".select2-container").css({'border': '','border-radius': ''}); }
        });

        $( "#trainee_image" ).change(function() {
            if ($('#trainee_image').val() == "") {
                $('#perpic').children( ".dropify-wrapper" ).css("border", "1px solid red");
            }else {
                $('#perpic').children( ".dropify-wrapper" ).css("border", "");
            }
        });
    </script>

    <!-- Country -->
    <script type="text/javascript">
        $('#country').change(function(){
            event.preventDefault()
            var countryID = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{url('get-states-list-trainee')}}",
                data: {'country_id' : countryID},
                success: function (data) {
                    $("#state").empty();
                    $("#state").append('<option value=""></option>');
                    $.each(data,function(key,value){
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                },
                error: function(jqXHR){
                    if(jqXHR.status==0) {
                        SwalMessage('You are offline','Connection to the server has been lost. Please check your internet connection and try again.','error');
                    } else{
                        SwalMessage('Attention','Something went wrong. Please try again later.','warning');
                    }
                }
            });
        });

        $('#country2').change(function() {
            event.preventDefault()
            var countryID = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{url('get-states-list-trainee')}}",
                data: {'country_id' : countryID},
                success: function (data) {
                    $("#state2").empty();
                    $("#state2").append('<option value=""></option>');
                    $.each(data,function(key,value){
                        $("#state2").append('<option value="'+key+'">'+value+'</option>');
                    });
                },
                error: function(jqXHR){
                    if(jqXHR.status==0) {
                        SwalMessage('You are offline','Connection to the server has been lost. Please check your internet connection and try again.','error');
                    } else{
                        SwalMessage('Attention','Something went wrong. Please try again later.','warning');
                    }
                }
            });
        });
    </script>

    <!-- Validation -->
    <script type="text/javascript">
        $('#finish').click( function() {
            $(".select2").each(function() {
                if ($(this).val() == "") {
                    $(this).siblings(".select2-container").css({'border': '1px solid red','border-radius': '5px'});
                }else {
                    $(this).siblings(".select2-container").css({'border': '','border-radius': ''});
                }
            });

            if ($('#prefix').val() == "" || $('#first_name').val() == "" || $('#last_name').val() == "" || $('#gender').val() == "" || $('#marital_status').val() == "" || $('#birthdate').val() == "" || $('#blood').val() == "" || $('#Nationality').val() == "") {
                $('#apers').css("color","red");
                $('#apers').text("* ");
            }else {
                $('#apers').css("color","");
                $('#apers').text("");
            }

            if ($('#hire_date').val() == "" || $('#job_type_id').val() == "" || $('#status_id').val() == "" || $('#department').val() == "" || $('#position').val() == "" || $('#line').val() == "") {
                $('#ajobs').css("color","red");
                $('#ajobs').text("* ");
            }else {
                $('#ajobs').css("color","");
                $('#ajobs').text("");
            }

            if ($('#email').val() == "" || $('#system_email').val() == "" || $('#country').val() == "" || $('#state').val() == "" || $('#address').val() == "" || $('#relationship').val() == "" || $('#fname_emer').val() == "" || $('#lname_emer').val() == "" || $('#house_phone').val() == "" || $('#mobile_phone').val() == "") {
                $('#acont').css("color","red");
                $('#acont').text("* ");
            }else {
                $('#acont').css("color","");
                $('#acont').text("");
            }

            var r = $('.repeater-custom-show-hide').repeaterVal();
            for (a = 0; a < r['phones'].length; a++) {
                if ($('select[name="phones['+a+'][phone_type]"]').val() == "" || $('input[name="phones['+a+'][number]"]').val() == "") {
                    $('#acont').css("color","red");
                    $('#acont').text("* ");
                }else {
                    $('#acont').css("color","");
                    $('#acont').text("");
                }
            }
        });
    </script>

    <!-- Submit Form -->
    <script type="text/javascript">
        $('#form').on('submit', function(event) {
            $('#finish').attr('disabled', true);
            event.preventDefault()
            var formData = new FormData(this)
            $.ajax({
                type: "POST",
                url: "/EditTrainee",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    window.location.replace('/TraineeProfile/'+data);
                },
                error: function(jqXHR){
                    if(jqXHR.status==0) {
                        SwalMessage('You are offline','Connection to the server has been lost. Please check your internet connection and try again.','error');
                    } else{
                        SwalMessage('Attention','Something went wrong. Please try again later.','warning');
                    }
                    $('#finish').attr('disabled', false);
                }
            });
        });
    </script>
@endsection
