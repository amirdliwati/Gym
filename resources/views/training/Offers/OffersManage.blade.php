@extends('layouts.app')
@section('css')
    <title>{{__('Offers')}}</title>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable-extension.css') }}">
    <style>.select2-container{z-index:100000;}</style>
@endsection
@section('breadcrumb')
    <h3>{{__('Offers')}}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
        <li class="breadcrumb-item">{{ Auth::user()->roles->first()->blug }}</li>
        <li class="breadcrumb-item active">{{__('Offers')}}</li>
    </ol>
@endsection
@section('bookmark')
    <li><button type="button" class="btn btn-outline-primary" data-toggle="modal"  data-target="#modaladdOffers"><i class="fa fa-plus-square-o mr-2"></i>{{__('Add New Offer')}}</button></li>
@endsection
@section('content')
<!-- Main content -->
<div class="card">
    <div class="card-header b-l-primary border-3"><h5> {{__('Management Offers')}}</h5> @include('layouts/button_card') </div>
    <div class="card-body">
        <div class="row">
            <table id="offers-table" class="table table-bordered table-hover table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 3; width: 100%;">
                <thead>
                    <tr style="text-align: center;">
                        <th class="text-primary">{{__('OfferID')}}</th>
                        <th class="text-primary">{{__('Title')}}</th>
                        <th class="text-primary">{{__('Created At')}}</th>
                        <th class="text-primary">{{__('Start Date')}}</th>
                        <th class="text-primary">{{__('Trainee Count')}}</th>
                        <th class="text-primary">{{__('Expire Date')}}</th>
                        <th class="text-primary">{{__('Offer Amount')}}</th>
                        <th class="text-primary">{{__('Controller')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($Offers as $Offer)
                    <tr style="text-align: center;">
                        <td>{{$Offer->id}}</td>
                        <td>{{$Offer->title}}</td>
                        <td>
                            <span class="badge badge-info">{{\Carbon\Carbon::parse($Offer->created_at)->isoFormat('Do MMMM YYYY')}}</span>
                        </td>
                        <td>
                            <span class="badge badge-success">{{\Carbon\Carbon::parse($Offer->start_date)->isoFormat('Do MMMM YYYY')}}</span>
                        </td>
                        <td>{{$Offer->count_trainee}}</td>
                        <td>
                            <span class="badge badge-warning">{{\Carbon\Carbon::parse($Offer->expire_date)->isoFormat('Do MMMM YYYY')}}</span>
                        </td>
                        <td>
                            <span class="badge badge-success">{{$Offer->currencie->symbol}}</span>   {{$Offer->amount}}
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary" type="button" onclick="GetOfferDetails('{{$Offer->id}}')"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-warning" type="button" onclick="GoToPage('EditOffer/{{$Offer->id}}')"><i class="fa fa-edit"></i></button>
                                @if(!empty($Offer->offer_detail))
                                    <button class="btn btn-danger btn-delete" type="button"><i class="fa fa-trash-o"></i></button>
                                @else
                                    <button class="btn btn-dark" type="button" onclick="SwalMessage('Attention','You can not delete this offer.','error')"><i class="fa fa-trash-o"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--modal Add Offers-->
<form id="form" enctype="multipart/form-data" data-parsley-required-message="">
    @csrf
    <!-- Modal view -->
    <div class="modal fade" id="modaladdOffers" role="dialog" aria-labelledby="viewModel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="viewModel">{{__('Add New Offer')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
	                    	<label for="title" class="col-form-label text-right">{{__('Title')}}</label>
	                    	<input type="text" class="form-control mx" placeholder="title" id="title" name="title" value="{{ old('title') }}" autocomplete="title" maxlength="100" autofocus required>
	                    </div>
                        <div class="col-md-3">
                            <label for="currency" class="col-form-label text-right">{{__('Choose Currency')}}</label>
                            <select class="form-control" id="currency" name="currency" autofocus required>
                                @foreach($Currencies as $Currency)
                                    <option value="{{$Currency->id}}"> {{$Currency->name}} -> {{$Currency->code}} -> {{$Currency->symbol}}</option>
                                @endforeach
                            </select>
                        </div> <!-- end col -->
                        <div class="col-md-3">
                            <label for="start_date" class="col-form-label text-right">{{__('Start Date')}}</label>
                            <div class="input-group">
                                <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                <input type="text" class="form-control datem initDate" placeholder="mm/dd/yyyy" id="start_date" name="start_date" value="{{ old('start_date') }}" autocomplete="start_date" readonly required>
                            </div>
                        </div> <!-- end col -->
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="count_trainee" class="col-form-label text-right">{{__('Trainees Count')}}</label>
                            <input class="form-control ts" type="number" name="count_trainee" id="count_trainee" value="1" placeholder="~1" autocomplete="count_trainee" autofocus required>
                        </div> <!-- end col -->
                        <div class="col-md-4">
                            <label for="expire_date" class="col-form-label text-right">{{__('Expire Date')}}</label>
                            <div class="input-group">
                                <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                <input type="text" class="form-control datem" placeholder="mm/dd/yyyy" id="expire_date" name="expire_date" value="{{ old('expire_date') }}" autocomplete="expire_date" readonly required>
                            </div>
                        </div> <!-- end col -->
	                    <div class="col-md-4">
                            <label for="amount" class="col-form-label text-right">{{__('Amount')}}</label>
                            <input class="form-control ts-money" type="number" step="0.01" name="amount" id="amount" value="0" placeholder="~0.0" autocomplete="amount" autofocus required>
                        </div> <!-- end col -->
                    </div><!--end row--> <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="details" class="col-form-label text-right">{{__('Details')}}</label>
                            <textarea id="details" name="details" class="form-control" cols="10" rows="2" required>{{ old('details') }}</textarea>
                        </div><!--end col-->
                    </div><!--end row-->
                </div> <!--end modal-body-->
                <div class="modal-footer">
                    <button type="submit" id="finish" class="btn btn-success-gradien">{{__('Save')}}</button>
                    <button type="button" class="btn btn-secondary-gradien" data-dismiss="modal" onclick="this.form.reset()">{{__('Close')}}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>

<!--Modal View Offer Details-->
<div class="modal fade bs-example-modal-lg" id="modalDetailsOffer" role="dialog" aria-labelledby="viewModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="viewModel">{{__('Offer Details')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="details-offer"></div>
                    </div><!-- end col -->
                </div><!--end row-->
            </div> <!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-gradien" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('javascript')
    <!-- Plugins js -->
    <script src="{{ asset('js/moment/moment.js') }}"></script>
    <script src="{{ asset('js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('js/touchspin/touchspin.js') }}"></script>
    <script src="{{ asset('js/parsleyjs/parsley.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>

    <!-- ckeditor js -->
    <script src="{{ asset('js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('js/ckeditor-custom/offer-app.js') }}"></script>

    <!-- Other Scripts -->
    <script type="text/javascript">
        $('form').parsley();
        $('.mx').maxlength({warningClass: "badge badge-info",limitReachedClass: "badge badge-warning",alwaysShow :true});
        $('.datem').datepicker();
        $('#currency').select2({width: '100%', placeholder: 'Select an option', dropdownParent: $('#modaladdOffers')});

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('.initDate').val(today);

        $('.ts').TouchSpin({min: 1,max: 100,step: 1,decimals: 0,boostat: 5,maxboostedstep: 10,buttondown_class: 'btn btn-info-gradien',buttonup_class: 'btn btn-primary-gradien'});

        $('.ts-money').TouchSpin({min: 0,max: 9999999999,step: 0.01,decimals: 2,boostat: 5,maxboostedstep: 10,buttondown_class: 'btn btn-info-gradien',buttonup_class: 'btn btn-primary-gradien'});

        var table = $('#offers-table').DataTable({"order": [[ 0, "desc" ]],"columnDefs": [{"targets": [ 0 ],"visible": false,"searchable": false},]});

        $( ".select2" ).change(function() {
            if ($(this).val() == "") { $(this).siblings(".select2-container").css({'border': '1px solid red','border-radius': '5px'}); }
            else { $(this).siblings(".select2-container").css({'border': '','border-radius': ''}); }
        });

        $('#finish').click( function() {
            $(".select2").each(function() {
                if ($(this).val() == "") {
                    $(this).siblings(".select2-container").css({'border': '1px solid red','border-radius': '5px'});
                }else {
                    $(this).siblings(".select2-container").css({'border': '','border-radius': ''});
                }
            });
        });
    </script>

    <!-- Submit Offer -->
    <script type="text/javascript">
        $('#form').on('submit', function(event) {
            for ( instance in CKEDITOR.instances ) {CKEDITOR.instances[instance].updateElement();}
            $('#finish').attr('disabled', true);
            event.preventDefault()
            var formData = new FormData(this)
            $.ajax({
                type: "POST",
                url: "/Offers",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#modaladdOffers").modal("hide");
                    swal({
                        title: 'Success',
                        text: 'The Offer has been added successfully.',
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

    <!-- Delete Offer -->
    <script type="text/javascript">
        $('#offers-table tbody').on( 'click', '.btn-delete', function () {
            var table = $('#offers-table').DataTable();
            var OfferID = table.row( $(this).parents('tr') ).data()[0];
            var row = table.row( $(this).parents('tr') );
            swal({
                title: 'Caution',
                text: 'Are you sure you want to delete this offer?',
                type: 'warning',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
                preConfirm: function (){
                    $.ajax({
                        type: "GET",
                        url: " /DeleteOffer/" + OfferID,
                        contentType: false,
                        success: function (data) {
                            if (data == 'Access Denied'){
                                SwalMessage('Access Denied!','You do not have permission for deleting.','error');
                            } else {
                                swal({
                                    title: 'Success',
                                    text: 'Offer has been deleted.',
                                    type: 'success',
                                    preConfirm: function (){
                                        row.remove().draw();
                                    }
                                });
                            }
                        },
                        error: function(jqXHR){
                            if(jqXHR.status==0) {
                                SwalMessage('You are offline','Connection to the server has been lost. Please check your internet connection and try again.','error');
                            } else{
                                SwalMessage('Attention','Something went wrong. Please try again later.','warning');
                            }
                        }
                    });
                }
            });
        });
    </script>

    <!-- Get Offer Details -->
    <script type="text/javascript">
        function GetOfferDetails(OfferID){
            $.ajax({
                type: "GET",
                url: "/GetOfferDetails",
                data: {'OfferID' : OfferID},
                cache:false,
                contentType: false,
                success: function (data) {
                    $("#details-offer").html(data);
                    $("#modalDetailsOffer").modal("show");
                },
                error: function(jqXHR){
                    if(jqXHR.status==0) {
                        SwalMessage('You are offline','Connection to the server has been lost. Please check your internet connection and try again.','error');
                    } else{
                        SwalMessage('Attention','Something went wrong. Please try again later.','warning');
                    }
                }
            });
        };
    </script>
@endsection
