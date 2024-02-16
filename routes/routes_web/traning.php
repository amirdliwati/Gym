<?php

use App\Http\Controllers\training\TraineesController;
use App\Http\Controllers\training\MembershipController;
use App\Http\Controllers\training\AttendanceController;
use App\Http\Controllers\training\OffersController;

//Add Trainee
    Route::post('/AddTrainee', [TraineesController::class, 'AddTrainee'])->name('AddTraineePost');
    Route::get('/AddTrainee', [TraineesController::class, 'AddTrainee'])->name('AddTrainee');

// Trainee Profile
    Route::get('/TraineeProfile/{id}', [TraineesController::class, 'TraineeProfile'])->name('TraineeProfile');

// All Trainees
    Route::get('/Trainees', [TraineesController::class, 'ViewTrainees'])->name('Trainees');

//Add Trainee
    Route::post('/EditTrainee', [TraineesController::class, 'EditTrainee'])->name('EditTraineePost');
    Route::get('/EditTrainee/{TraineeID}', [TraineesController::class, 'EditTrainee'])->name('EditTrainee');

//Calendar
    Route::post('/Calendar', [TraineesController::class, 'Calendar'])->name('CalendarPost');
    Route::get('/Calendar', [TraineesController::class, 'Calendar'])->name('Calendar');

//Memberships
    Route::post('/Memberships', [MembershipController::class, 'Memberships'])->name('MembershipsPost');
    Route::get('/Memberships', [MembershipController::class, 'Memberships'])->name('Memberships');

// To Feed Ajax
    Route::get('get-states-list-trainee', [TraineesController::class, 'getStateList'])->name('get-states-list-trainee');

//Change Status
    Route::post('/ChangeStatusTrainee', [TraineesController::class, 'ChangeStatusTrainee'])->name('ChangeStatusTraineePost');

// Attendances
    Route::get('/TraineeAttendances', [AttendanceController::class, 'ViewAttendances'])->name('ViewAttendances');
    Route::get('/SearchTraineeAttendance', [AttendanceController::class, 'SearchTraineeAttendance'])->name('SearchTraineeAttendance');
    Route::get('change-attendance-sync-trainee', [AttendanceController::class, 'ChangeAttendanceSync'])->name('change-attendance-sync-trainee');
    Route::get('change-punch-state-trainee', [AttendanceController::class, 'ChangePunchState'])->name('change-punch-state');

//Offers
    Route::post('/EditOffer', [OffersController::class, 'EditOffer'])->name('EditOfferPost');
    Route::get('/EditOffer/{OfferID}', [OffersController::class, 'EditOffer'])->name('EditOffer');

    Route::post('/Offers', [OffersController::class, 'Offers'])->name('OffersPost');
    Route::get('/Offers', [OffersController::class, 'Offers'])->name('Offers');

    Route::get('/DeleteOffer/{OfferID}', [OffersController::class, 'DeleteOffer'])->name('DeleteOffer');
    Route::get('/GetOfferDetails', [OffersController::class, 'GetOfferDetails'])->name('GetOfferDetails');
