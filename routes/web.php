<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubstituteController;
use App\Http\Controllers\TeacherController;
use App\Models\TimeTable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('teacher');
});

Route::resource('teacher',TeacherController::class)->except(['show','edit']);
Route::resource('section',SectionController::class)->except(['show','edit']);
Route::resource('teacher.schedule',ScheduleController::class)->except(['show','edit','update']);
Route::resource('section.schedule',ScheduleController::class)->except(['show','edit','update']);
Route::resource('teacher.absent',AbsentController::class)->only(['store','destroy','index']);
Route::resource('substitute',SubstituteController::class);
Route::get('/run-seeder', function () {
    if (TimeTable::all()->count() ==0)
    Artisan::call('db:seed');
    return to_route('teacher.index');
}
);