@extends('layouts.app')
@section('css')
    <title>{{__('Attendances Trainees')}}</title>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable-extension.css') }}">
@endsection
@section('breadcrumb')
    <h3>{{__('Attendances Trainees')}}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
        <li class="breadcrumb-item">{{ Auth::user()->roles->first()->blug }}</li>
        <li class="breadcrumb-item active">{{__('Attendances Trainees')}}</li>
    </ol>
@endsection
@section('bookmark')
    <li><button type="button" class="btn-sm btn-pill btn-outline-primary" onclick="RefreshPage()"><i data-feather="refresh-cw"></i></button></li>
@endsection
@section('content')
<!-- Main content -->
<div class="card">
    <div class="card-header b-l-success border-3">
        <div class="row">
            <div class="col-md-3">
                <label for="Trainees" class="col-form-label text-right">{{__('Choose Trainee')}}</label>
                <select class="form-control select2" id="Trainees" name="Trainees" autofocus required>
                    <option selected="selected" value="{{ old('Trainees') }}"></option>
                    @foreach($Trainees as $Trainee)
                        <option value="{{$Trainee->id}}"> {{$Trainee->first_name}} {{$Trainee->middle_name}} {{$Trainee->last_name}}</option>
                    @endforeach
                </select>
            </div> <!-- end col -->
            <div class="col-md-3">
                <label for="start_date" class="col-form-label text-right">{{__('Start Date')}}</label>
                <div class="input-group">
                    <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                    <input name="start_date" type="text" class="form-control datem" placeholder="mm/dd/yyyy" id="start_date" readonly>
                </div><!-- input-group -->
            </div> <!-- end col -->
            <div class="col-md-3">
                <label for="end_date" class="col-form-label text-right">{{__('End Date')}}</label>
                <div class="input-group">
                    <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                    <input name="end_date" type="text" class="form-control" placeholder="mm/dd/yyyy" id="end_date" readonly>
                </div><!-- input-group -->
            </div> <!-- end col -->
            <div class="col-md-3">
                <label class="col-form-label text-right">{{__('Punch State')}}</label>
                    <br>
                <div class="checkbox checkbox-success form-check-inline">
                    <input type="checkbox" id="check-status0" value="Check IN" onchange="FilterState()" checked>
                    <label for="check-status0"> {{__('Check IN')}} </label>
                </div>
                <div class="checkbox checkbox-danger form-check-inline">
                    <input type="checkbox" id="check-status1" value="Check Out" onchange="FilterState()" checked>
                    <label for="check-status1"> {{__('Check Out')}} </label>
                </div>
            </div> <!-- end col -->
        </div><!-- end row -->
        @include('layouts/button_card')
    </div>
    <div class="card-body">
        <div class="row">
            <table id="attendances-table" class="table table-bordered table-hover table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 3; width: 100%;">
                <thead>
                <tr style="text-align: center;">
                    <th class="text-primary">{{__('Attendance ID')}}</th>
                    <th class="text-primary">{{__('Trainee Name')}}</th>
                    <th class="text-primary">{{__('Branch')}}</th>
                    <th class="text-primary">{{__('Punch State Hidden')}}</th>
                    <th class="text-primary">{{__('Punch State')}}</th>
                    <th class="text-primary">{{__('Punch Time')}}</th>
                    <th class="text-primary">{{__('Device S/N')}}</th>
                    <th class="text-primary">{{__('Device Name')}}</th>
                    <th class="text-primary">{{__('Accept')}}</th>
                </tr>
                </thead>
                <tbody style="text-align: center;">
                    @foreach ($Attendances as $Attendance)
                    <tr style="text-align: center;">
                        <td>{{$Attendance->id}}</td>
                        <td>{{$Attendance->trainee->first_name}} {{$Attendance->trainee->middle_name}} {{$Attendance->trainee->last_name}}</td>
                        <td>{{$Attendance->trainee->position->department->name}}</td>
                        @switch($Attendance->punch_state)
                            @case(0)
                                <td>{{__('Check IN')}}</td>
                            @break
                            @case(1)
                                <td>{{__('Check Out')}}</td>
                            @break
                        @endswitch

                        @switch($Attendance->punch_state)
                            @case(0)
                                <td>
                                    <select class="form-control" onchange ="ChangePunchState({{$Attendance->id}},this.value)">
                                        <option selected="selected" value="0">{{__('Check IN')}}</option>
                                        <option value="1">{{__('Check Out')}}</option>
                                    </select>
                                </td>
                            @break
                            @case(1)
                                <td>
                                    <select class="form-control" onchange ="ChangePunchState({{$Attendance->id}},this.value)">
                                        <option selected="selected" value="1">{{__('Check Out')}}</option>
                                        <option value="0">{{__('Check IN')}}</option>
                                    </select>
                                </td>
                            @break
                        @endswitch
                        <td><span class="badge badge-info">{{\Carbon\Carbon::parse($Attendance->punch_time)->isoFormat('Do MMMM YYYY, h:mm:ss a')}}</span></td>
                        <td>{{$Attendance->terminal_sn}}</td>
                        <td>{{$Attendance->terminal_alias}}</td>
                        <td>
                            <div class="mb-3"></div>
                        @if ($Attendance->sync == 0)
                            <div class="media-body text-right icon-state">
                                <label class="switch">
                                    <input type="checkbox" id="sync{{$Attendance->id}}" onclick="sync('{{$Attendance->id}}')"><span class="switch-state"></span>
                                </label>
                            </div>
                        @else
                            <div class="media-body text-right icon-state">
                                <label class="switch">
                                    <input type="checkbox" id="sync{{$Attendance->id}}" checked="" onclick="sync('{{$Attendance->id}}')"><span class="switch-state"></span>
                                </label>
                            </div>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- end row -->
    </div> <!-- end card-body -->
    <div class="card-footer">
        <a href="{{ route('home') }}"><button type="button" class="btn btn-warning-gradien btn-pill"><i class="mdi mdi-backup-restore mr-1"></i>{{__('Back To Home')}}</button></a>
    </div>
</div> <!-- end card -->
@endsection

@section('javascript')

    <!-- Plugins js -->
    <script src="{{ asset('js/moment/moment.js') }}"></script>
    <script src="{{ asset('js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>

    <!-- Other Scripts -->
    <script type="text/javascript">
        $('#end_date').datepicker({onSelect: function () {SearchTrainee($('#end_date').val());}});
        $('#start_date').datepicker();
        $(".select2").select2({width: '100%', placeholder: 'Select an option'});

        var table = $('#attendances-table').DataTable({buttons: ['copy','excel','colvis'],"columnDefs": [{"targets": [ 0 ],"visible": false,"searchable": false},{"targets": [ 3 ],"visible": false},]});
        table.buttons().container().prependTo('#attendances-table_length');
        table.buttons().container().siblings("label").prepend('&nbsp;&nbsp;&nbsp;');
    </script>

    <script type="text/javascript">
        function SearchTrainee(EndDate){
           var traineeID = $('#Trainees').val();
           var start_date = formatDate($('#start_date').val());
            $.ajax({
                type: "GET",
                url: "{{url('SearchTraineeAttendance')}}?trainee_id="+traineeID+"&start_date="+start_date+"&end_date="+formatDate(EndDate),
                contentType: 'application/json',
                cache:false,
                success: function (data) {
                    if (data == ''){
                        $('#attendances-table').DataTable().clear().draw();
                        SwalMessage('Sorry!','No data available for this trainee.','info');
                    }
                    else {
                        var table = $('#attendances-table').DataTable( {
                            buttons: ['copy','excel','colvis'],
                            "destroy": true,
                            "data": data,
                            "columns": [
                                {"data": "id" },
                                {"data": "trainee_name" },
                                {"data": "department" },
                                {"data": "punch_state_hidden" },
                                {"data": "punch_state" },
                                {"data": "punch_time" },
                                {"data": "terminal_sn" },
                                {"data": "terminal_alias" },
                                {"data": "modify" }],
                            "columnDefs": [{"targets": [ 0 ],"visible": false},
                                        {"targets": [ 3 ],"visible": false,"render": function ( data, type, row, meta ) {
                                                switch (data) {
                                                    case 0:
                                                        return 'Check IN';
                                                    break;
                                                    case 1:
                                                        return 'Check Out';
                                                    break;
                                                }
                                            }},
                                        {"targets": [ 4 ],"render": function ( data, type, row, meta ) {
                                                switch (data['state']) {
                                                    case 0:
                                                        return '<select class="custom-select" onchange ="ChangePunchState('+data['id']+',this.value)"><option selected="selected" value="0">Check IN</option><option value="1">Check Out</option></select>';
                                                    break;
                                                    case 1:
                                                        return '<select class="custom-select" onchange ="ChangePunchState('+data['id']+',this.value)"><option selected="selected" value="1">Check Out</option><option value="0">Check IN</option></select>';
                                                    break;

                                            }},
                                        {"targets": [ 8 ],"render": function ( data, type, row, meta ) {
                                            if ( data['sync'] == 0) {
                                                return '<div class="media-body text-right icon-state"><label class="switch"><input type="checkbox" id="sync'+data['id']+'" onclick="sync('+data['id']+')"><span class="switch-state"></span></label></div>';
                                            } else {
                                                return '<div class="media-body text-right icon-state"><label class="switch"><input type="checkbox" id="sync'+data['id']+'" checked="" onclick="sync('+data['id']+')"><span class="switch-state"></span></label></div>';
                                            }

                                            }},
                                        ]
                        });

                        table.buttons().container().prependTo('#attendances-table_length');
                        table.buttons().container().siblings("label").prepend('&nbsp;&nbsp;&nbsp;');

                    }

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
        };
    </script>

    <script type="text/javascript">
        function FilterState() {
            let query = '';
            for (let i = 0; i < 2; i++) {
                if ($('#check-status'+i).prop("checked") == true) {
                    query = query + "|" + $('#check-status'+i).val();
                }
            }

            $('#attendances-table').DataTable().columns( 3 ).search( query.substring(1), true, false).draw();
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
    </script>

    <script type="text/javascript">
        function sync(AttendanceID) {
            $.ajax({
                type: "GET",
                url: "{{url('change-attendance-sync-trainee')}}",
                data: {'AttendanceID': AttendanceID},
                cache:false,
                contentType: false,
                success: function (data) {
                    if (data == 'pass') {
                        NotifyMessage('Success','The attendance has been accepted.','success');
                    } else if(data == 'fail') {
                        NotifyMessage('Reject','The attendance has been rejected.','danger');
                    } else {
                        NotifyMessage('Access Denied','Access Denied.','danger');
                    }
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
        };
    </script>

    <script type="text/javascript">
        function ChangePunchState(AttendanceID , PunchState) {
            $.ajax({
                type: "GET",
                url: "{{url('change-punch-state-trainee')}}",
                data: {'AttendanceID': AttendanceID , 'PunchState': PunchState},
                cache:false,
                contentType: false,
                success: function (data) {
                    if (data == 'Check IN') {
                        NotifyMessage('Success','The State has been changed to Check IN.','success');
                    }
                    else if (data == 'Check Out') {
                        NotifyMessage('Success','The State has been changed to' + data,'danger');
                    }
                    else {
                        NotifyMessage('Access Denied','Access Denied','danger');
                    }

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
        };
    </script>
@endsection
