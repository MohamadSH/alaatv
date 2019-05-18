<?php

use App\HelpDesk\Controllers\TicketController;
use App\HelpDesk\Controllers\Web\CommentsController;
use Imanghafoori\HeyMan\Facades\HeyMan;
Heyman::whenYouHitRouteName('ticket.toggleIsOpen')->thisValueShouldAllow(false)->otherwise()->response()->json('sdcssd');

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'h'], function () {

    Route::resource('t', TicketController::class);
    Route::get('t/toggle-is-open/{ticket_id}', [TicketController::class, 'toggleIsOpen'])->name('ticket.toggleIsOpen');
    //Route::post('ticket/toggle-is-open/{ticket_id}', [TicketController::class, 'toggleIsOpen'])->name('ticket.toggleIsOpen');
    Route::post('t/submit', [TicketController::class, 'submit'])->name('ticket.submit');
    Route::post('t/{ticket_id}/add-comment', [CommentsController::class, 'addComment'])->name('ticket.addComment');
    Route::post('t/{ticket_id}/change-agent', [CommentsController::class, 'changeAgent'])->name('ticket.changeAgent');
});
\Event::listen(\Illuminate\Routing\Events\RouteMatched::class, function($t){
//    dd($t->route->getName());
});