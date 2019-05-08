<?php

namespace App\HelpDesk\Controllers;

use Illuminate\Http\Request;
use App\HelpDesk\Models\Ticket;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * TicketController constructor.
     */
    public function __construct()
    {
        $this->callMiddlewares();
    }
    
    
    /**
     * @param $authException
     */
    private function callMiddlewares(): void
    {
        /*$this->middleware('permission:'.config('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), [
            'only' => [
                'store',
                'create',
                'create2',
            ],
        ]);
        $this->middleware('permission:'.config('constants.EDIT_EDUCATIONAL_CONTENT'), [
            'only' => [
                'update',
                'edit',
            ],
        ]);
        $this->middleware('permission:'.config('constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS'),
            ['only' => 'destroy']);
        
        $this->middleware('convert:order|title', [
            'only' => [
                'store',
                'update',
            ],
        ]);*/
    }
    

    public function index()
    {
        $tickets = Ticket::all();
    
        //User Tickets
        //Agent Tickets
        //All Tickets -> Admin
    
        return view('helpDesk::ticket.index', compact('tickets'));
    }
    
    public function create()
    {
    }
    
    
    public function store(Request $request)
    {
    }
    
    
    public function show(Ticket $ticket)
    {
    }
    
    
    public function edit(Ticket $ticket)
    {
    }
    
    
    public function update(Request $request, Ticket $ticket)
    {
    }
    
    
    public function destroy(Ticket $ticket)
    {
    }
}
