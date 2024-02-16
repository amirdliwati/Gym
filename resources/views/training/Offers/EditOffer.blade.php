@extends('layouts.app')
@section('css')
    <title>{{__('Modify Offer')}}</title>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb')
    <h3>{{__('Modify Offer')}}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
        <li class="breadcrumb-item">{{ Auth::user()->roles->first()->blug }}</li>
        <li class="breadcrumb-item">{{__('Offers')}}</li>
        <li class="breadcrumb-item active">{{__('Modify Offer')}}</li>
    </ol>
@endsection
@section('bookmark')
    <li><button type="button" class="btn-sm btn-pill btn-outline-primary" onclick="RefreshPage()"><i data-feather="refresh-cw"></i></button></li>
@endsection
@section('content')
<!-- Main content -->
<form id="form" enctype="multipart/form-data" data-parsley-required-message="">
    @csrf
    <input type="hidden" id="OfferID" name="OfferID" value="{{$Offer->id}}">
    <div class="card">
        <div class="card-header b-l-warning border-3"><h5> {{__('Modify Offer')}} ({{$Offer->id}})</h5> @include('layouts/button_card') </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="title" class="col-form-label text-right">{{__('Title')}}</label>
                    <input type="text" class="form-control mx" placeholder="title" id="title" name="title" value="{{$Offer->title}}" autocomplete="title" maxlength="100" autofocus required>
                </div>
                <div class="col-md-3">
                    <label for="currency" class="col-form-label text-right">{{__('Choose Currency')}}</label>
                    <select class="form-control" id="currency" name="currency" autofocus required>
                        <option value="{{$Offer->currency_id}}" selected> {{$Offer->currencie->name}} -> {{$Offer->currencie->code}} -> {{$Offer->currencie->symbol}}</option>
                        @foreach($Currencies as $Currency)
                            <option value="{{$Currency->id}}"> {{$Currency->name}} -> {{$Currency->code}} -> {{$Currency->symbol}}</option>
                        @endforeach
                    </select>
                </div> <!-- end col -->
                <div class="col-md-3">
                    <label for="start_date" class="col-form-label text-right">{{__('Start Date')}}</label>
                    <div class="input-group">
                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                        <input type="text" class="form-control datem" placeholder="mm/dd/yyyy" id="start_date" name="start_date" value="{{$Offer->start_date}}" autocomplete="start_date" readonly required>
                    </div>
                </div> <!-- end col -->
            </div><!--end row--> <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="count_trainee" class="col-form-label text-right">{{__('Trainees Count')}}</label>
                    <input class="form-control ts" type="number" name="count_trainee" id="count_trainee" value="{{$Offer->count_trainee}}" placeholder="~1" autocomplete="count_trainee" autofocus required>
                </div> <!-- end col -->
                <div class="col-md-4">
                    <label for="expire_date" class="col-form-label text-right">{{__('Expire Date')}}</label>
                    <div class="input-group">
                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                        <input type="text" class="form-control datem" placeholder="mm/dd/yyyy" id="expire_date" name="expire_date" value="{{$Offer->expire_date}}" autocomplete="expire_date" readonly required>
                    </div>
                </div> <!-- end col -->
                <div class="col-md-4">
                    <label for="amount" class="col-form-label text-right">{{__('Amount')}}</label>
                    <input class="form-control ts-money" type="number" step="0.01" name="amount" id="amount" value="{{$Offer->amount}}" placeholder="~0.0" autocomplete="amount" autofocus required>
                </div> <!-- end col -->
            </div><!--end row--> <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="details" class="col-form-label text-right">{{__('Details')}}</label>
                    <textarea id="details" name="details" class="form-control" cols="10" rows="2" required>{{$Offer->offer_detail->description}}</textarea>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end card-body-->
        <div class="card-footer">
            <button id="finish" form="form" data-action="save-png" type="submit" class="btn btn-success-gradien btn-pill"><i class="mdi mdi-content-save-all mr-1"></i>{{__('Save')}}</button>
            <a href="{{route('Offers')}}"><button type="button" class="btn btn-warning-gradien btn-pill"><i class="mdi mdi-backup-restore mr-1"></i>{{__('Back To Offers')}}</button></a>
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

    <!-- ckeditor js -->
    <script src="{{ asset('js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('js/ckeditor-custom/offer-app.js') }}"></script>

    <!-- Other Scripts -->
    <script type="text/javascript">
        $('form').parsley();
        $('.mx').maxlength({warningClass: "badge badge-info",limitReachedClass: "badge badge-warning",alwaysShow :true});
        $('.datem').datepicker();
        $('#currency').select2({width: '100%', placeholder: 'Select an option'});

        $('.ts').TouchSpin({min: 1,max: 100,step: 1,decimals: 0,boostat: 5,maxboostedstep: 10,buttondown_class: 'btn btn-info-gradien',buttonup_class: 'btn btn-primary-gradien'});

        $('.ts-money').TouchSpin({min: 0,max: 9999999999,step: 0.01,decimals: 2,boostat: 5,maxboostedstep: 10,buttondown_class: 'btn btn-info-gradien',buttonup_class: 'btn btn-primary-gradien'});

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

    <!-- Submit Form -->
    <script type="text/javascript">
        $('#form').on('submit', function(event) {
            for ( instance in CKEDITOR.instances ) {CKEDITOR.instances[instance].updateElement();}
            $('#finish').attr('disabled', true);
            event.preventDefault()
            var formData = new FormData(this)
            $.ajax({
                type: "POST",
                url: "/EditOffer",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    swal({
                        title: 'Success',
                        text: 'Offer has been edited successfully.',
                        type: 'success',
                        preConfirm: function (){window.location.replace('/Offers');}
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
