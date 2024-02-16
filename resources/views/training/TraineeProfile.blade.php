@extends('layouts.app')
@section('css')
<title>{{__('Trainee Profile')}}</title>
@endsection
@section('breadcrumb')
    <h3>{{__('Trainee Profile')}}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
        <li class="breadcrumb-item">{{ Auth::user()->roles->first()->blug }}</li>
        <li class="breadcrumb-item active">{{__('Trainee Profile')}}</li>
    </ol>
@endsection
@section('bookmark')
    <li><button type="button" class="btn-sm btn-pill btn-outline-primary" onclick="RefreshPage()"><i data-feather="refresh-cw"></i></button></li>
@endsection
@section('content')
<!-- Main content -->
<div class="card">
    <div class="card-header b-l-primary border-3"><h5> {{__('Trainee Profile')}} ({{$Trainee->first_name}} {{$Trainee->last_name}}) </h5> @include('layouts/button_card') </div>
    <div class="card-body">
        <div class="row ">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <img src="{{asset($Trainee->image)}}" alt="" class="d-block mx-auto" height="300" width="235">
                    </div>
                    <div class="col-md-10 align-self-center offset-md-1"><br><br>
                        <div class="ribbon-wrapper">
                            <div class="card-body">
                                <div class="ribbon ribbon-bookmark ribbon-danger">{{__('Contact')}}</div>
                                @foreach($Trainee->phones as $phone)
                                    @if($phone->phone_type == 1)
                                    <i class="mdi mdi-cellphone-android text-primary"></i> <b>{{ __('Mobile') }}:</b>
                                    @elseif($phone->phone_type == 2)
                                    <i class="mdi mdi-phone-classic text-primary"></i> <b>{{ __('Home') }}:</b>
                                    @elseif($phone->phone_type == 3)
                                    <i class="mdi mdi-deskphone text-primary"></i> <b>{{ __('Work') }}:</b>
                                    @elseif($phone->phone_type == 4)
                                    <i class="mdi mdi-phone text-primary"></i> <b>{{ __('Other') }}:</b>
                                    @endif {{$phone->number}}
                                @endforeach
                            </div>
                        </div>
                        <div class="ribbon-wrapper">
                            <div class="card-body">
                                <div class="ribbon ribbon-bookmark ribbon-info">{{__('Addresses')}}</div>
                                @foreach($Trainee->addresses as $address)
                                <b><i class="fas fa-map-marker-alt text-primary"></i>
                                    @if($address->add_type == 1)
                                    {{__('Permanent') }}
                                    @else {{ __('Temporary')}}
                                    @endif {{__('Address')}}: {{$address->address}}, {{$address->state->name}}, {{$address->countrie->name}}.</b>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-md-6">
                <h4 class="text-muted">@if( $Trainee->prefix == 1 )
                    {{ __('Mr.') }}
                    @elseif($Trainee->prefix == 2 )
                    {{ __('Ms.')}}
                    @elseif($Trainee->prefix == 3 )
                    {{ __('Mrs.') }}
                    @elseif($Trainee->prefix == 4 )
                    {{ __('Dr.') }}
                    @elseif($Trainee->prefix == 5 )
                    {{ __('Eng.') }}
                @endif
                {{$Trainee->first_name}} {{$Trainee->middle_name}} {{$Trainee->last_name}}</h4>
                <p class="text-muted"></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="ribbon-wrapper">
                            <div class="card-body">
                                <div class="ribbon ribbon-bookmark ribbon-info">{{__('Basic Information')}}</div>
                                <b>{{__('DOB')}}: </b>{{\Carbon\Carbon::parse($Trainee->birthdate)->isoFormat('Do MMMM YYYY')}}<br>
                                <b>{{__('Gender')}}: </b>@if ($Trainee->gender == 1)
                                {{ __('Male') }}
                                @else
                                {{ __('Female') }}
                                @endif<br>
                                <b>{{__('Nationality')}}: </b>{{$Trainee->countrie->nationality}}<br>
                                <b>{{__('Marital Status')}}: </b>
                                @if($Trainee->marital_status == 1)
                                {{ __('Single') }}
                                @elseif($Trainee->marital_status == 2 )
                                {{ __('Married')}}
                                @elseif($Trainee->marital_status == 3 )
                                {{ __('Divorced')}}
                                @elseif($Trainee->marital_status == 4 )
                                {{ __('Widowed')}} @endif
                                <br>
                                @if ($Trainee->national_no != '')
                                <b>{{__('National ID')}}: </b>{{$Trainee->national_no}}<br> @endif
                                @if ($Trainee->passport != '')
                                <b>{{__('Passport ID')}}: </b>{{$Trainee->passport}}<br> @endif
                            </div>
                        </div>
                    </div>
                </div> <br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="ribbon-wrapper">
                            <div class="card-body">
                                <div class="ribbon ribbon-bookmark ribbon-primary">{{__('Membership Details')}}</div>
                                <b>{{__('Registration Date')}}: </b>{{\Carbon\Carbon::parse($Trainee->created_at)->isoFormat('Do MMMM YYYY')}}<br>
                                <b>{{__('Membership')}}: </b>{{$Trainee->membership->name}}<br>
                                <b>{{$Trainee->position->name}} | {{$Trainee->position->department->name}}</b><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="ribbon-wrapper">
                            <div class="card-body">
                                <div class="ribbon ribbon-bookmark ribbon-warning">{{__('In Emergency Case')}}</div>
                                @foreach($Trainee->emergencies as $emergency)
                                <b>{{__('Trainee')}}
                                    @if($emergency->relationship == 1)
                                    {{ __('Father') }}
                                    @elseif($emergency->relationship == 2)
                                    {{ __('Brother')}}
                                    @elseif($emergency->relationship == 3)
                                    {{ __('Sister')}}
                                    @elseif($emergency->relationship == 4)
                                    {{ __('Friend')}}
                                    @endif: {{$emergency->fname_emer}} {{$emergency->lname_emer}}</b>
                                <br>  <b>
                                    @if ($emergency->house_phone != null)
                                    <i class="mdi mdi-phone-classic text-primary"></i> {{__('House')}}: {{$emergency->house_phone}}<br>
                                    @endif
                                    @if ($emergency->mobile_phone != null)
                                    <i class="mdi mdi-cellphone-android text-primary"></i> {{__('Mobile')}}: {{$emergency->mobile_phone}}
                                    @endif </b>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end card-body-->
    <div class="card-footer">
        <a href="{{route('Trainees')}}"><button type="button" class="btn btn-warning-gradien btn-pill"><i class="mdi mdi-backup-restore mr-1"></i>{{__('Back To Trainees')}}</button></a>
    </div>
</div><!--end card-->
@endsection

@section('javascript')

@endsection
