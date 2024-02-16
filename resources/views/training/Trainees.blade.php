@extends('layouts.app')
@section('css')
    <title>{{__('Trainees Management')}}</title>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable-extension.css') }}">
    <style>.select2-container{z-index:100000;}</style>
@endsection
@section('breadcrumb')
    <h3>{{__('Trainees Management')}}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
        <li class="breadcrumb-item">{{ Auth::user()->roles->first()->blug }}</li>
        <li class="breadcrumb-item active">{{__('Trainees Management')}}</li>
    </ol>
@endsection
@section('bookmark')
    <li><button type="button" class="btn-sm btn-pill btn-outline-primary" onclick="RefreshPage()"><i data-feather="refresh-cw"></i></button></li>
@endsection
@section('content')
<!-- Page Content-->
<div class="card">
    <div class="card-header b-l-primary border-3"><h5> {{__('Trainees Management')}} </h5> @include('layouts/button_card') </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12" >
                <table id="employees-table" class="table table-bordered table-hover table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 3; width: 100%;">
                    <thead>
                        <tr style="text-align: center;">
                            <th class="text-primary">{{__('ID')}}</th>
                            <th class="text-primary">{{__('Full Name')}}</th>
                            <th class="text-primary">{{__('Registered Date')}}</th>
                            <th class="text-primary">{{__('Status')}}</th>
                            <th class="text-primary">{{__('Controller')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($Users as $User)
                        <tr style="text-align: center;">
                            <td>{{$User->trainee->id}}</td>
                            <td>
                                @if( $User->trainee->prefix == 1 ) {{ __('Mr.') }}
                                    @elseif($User->trainee->prefix == 2 ) {{ __('Ms.')}}
                                    @elseif($User->trainee->prefix == 3 ) {{ __('Mrs.') }}
                                    @elseif($User->trainee->prefix == 4 ) {{ __('Dr.') }}
                                    @elseif($User->trainee->prefix == 5 ) {{ __('Eng.') }}
                                @endif
                                {{$User->trainee->first_name}} {{$User->trainee->middle_name}} {{$User->trainee->last_name}}
                            </td>
                            <td><span class="badge badge-success">{{\Carbon\Carbon::parse($User->trainee->created_at)->isoFormat('Do MMMM YYYY')}}</span></td>

                            @switch($User->trainee->status)
                                @case(1)
                                    <td><span class="badge badge-info">{{__('New')}}</span></td>
                                @break
                                @case(2)
                                    <td><span class="badge badge-success">{{__('Registered')}}</span></td>
                                @break
                                @case(3)
                                    <td><span class="badge badge-danger">{{__('Canceled')}}</span></td>
                                @break
                                @case(4)
                                    <td><span class="badge badge-warning">{{__('Waiting')}}</span></td>
                                @break
                            @endswitch

                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary-gradien dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Select Option')}}</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                        <a class="dropdown-item" href="/TraineeProfile/{{$User->trainee->id}}"><i class="fa fa-eye font-primary mr-2"></i>{{__('View Profile')}}</a>

                                        @if (Auth::user()->roles->whereIn('title',['Admin_role','Training_role'])->first()->permissions->where('title','EditTrainee') != '[]')
                                        <a class="dropdown-item" href="/EditTrainee/{{$User->trainee->id}}"><i class="fa fa-edit font-warning mr-2"></i>{{__('Edit Profile')}}</a>
                                        @endif

                                        <div class="dropdown-divider"></div>

                                        @if (Auth::user()->roles->whereIn('title',['Admin_role','Training_role'])->first()->permissions->where('title','EditTrainee') != '[]')
                                        <a type="button" class="dropdown-item" data-toggle="modal"  data-target="#modalChangeStatus" onclick="SetTraineeID({{$User->trainee->id}})"><i class="fa fa-hand-o-up font-info mr-2"></i>{{__('Change Status')}}</a>
                                        @endif
                                    </div>
                                </div><!-- /btn-group -->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--end card-body-->
    <div class="card-footer">
        <a href="{{route('home')}}"><button type="button" class="btn btn-warning-gradien btn-pill"><i class="mdi mdi-backup-restore mr-1"></i>{{__('Back To Home')}}</button></a>
    </div>
</div><!--end card-->

<!-- Modal Change Status -->
<form id="form" data-parsley-required-message="">
    @csrf
    <input type="hidden" id="trainee_id" name="trainee_id" value="">
    <div class="modal fade bs-example-modal-md" id="modalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="viewModel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="viewModel">{{__('Change Trainee Status')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="container col-md-12">
                            <label for="status" class="col-form-label text-right">{{__('Job Status')}}</label>
                            <select class="form-control select2" id="status" name="status" autofocus required>
                                <option selected="selected" value=""></option>
                                <option value="1">{{__('New')}}</option>
                                <option value="2">{{__('Registered')}}</option>
                                <option value="3">{{__('Canceled')}}</option>
                                <option value="4">{{__('Waiting')}}</option>
                            </select>
                        </div>
                    </div><!--end row-->
                </div>
                <div class="modal-footer">
                    <button type="submit" id="finish" class="btn btn-success-gradien">{{__('Save')}}</button>
                    <button type="button" class="btn btn-secondary-gradien " data-dismiss="modal" onclick="this.form.reset();">{{__('Close')}}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>
@endsection
@section('javascript')
    <!-- Plugins js -->
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/parsleyjs/parsley.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>

    <!-- Other Scripts -->
    <script type="text/javascript">
        $('form').parsley();
        $(".select2").select2({width: '100%', placeholder: 'Select an option'});
        $('#employees-table').DataTable();

        function SetTraineeID(TraineeID) {$("#trainee_id").val(TraineeID);}
        $('#finish').click( function(){
            if ($('#status').val() == "") {
                $('#status').siblings(".select2-container").css({'border': '1px solid red','border-radius': '5px'});
            }
        });

        $("#status").change(function()
        {
            if ($('#status').val() == "") {
                $('#status').siblings(".select2-container").css({'border': '1px solid red','border-radius': '5px'});
            }else {
                $('#status').siblings(".select2-container").css({'border': '','border-radius': ''});
            }
        });
    </script>

    <!-- Submit form -->
    <script type="text/javascript">
        $('#form').on('submit', function(event) {
            $('#finish').attr('disabled', true);
            event.preventDefault()
            var formData = new FormData(this)
            $.ajax({
                type: "POST",
                url: "/ChangeStatusTrainee",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#modalChangeStatus").modal("hide");
                    swal({
                        title: 'Success',
                        text: 'Trainee status has been changed successfully.',
                        type: 'success',
                        preConfirm: function (){location.reload();}
                    });
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
