<?php

use Illuminate\Support\Facades\Route;
use App\ProgrammingCalendar;

Route::get('/debug-calendars', function () {
    return ProgrammingCalendar::all();
});
