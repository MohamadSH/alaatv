<?php

use App\HelpDesk\Controllers\TicketController;

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'h'], function () {
    
    Route::resource('t', TicketController::class);
    
    
});