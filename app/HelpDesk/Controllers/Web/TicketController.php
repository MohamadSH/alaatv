<?php

namespace App\HelpDesk\Controllers;

use Illuminate\Http\Request;
use App\HelpDesk\Models\Ticket;
use App\HelpDesk\Models\Priority;
use App\HelpDesk\Models\Category;
use App\Http\Controllers\Controller;
use App\HelpDesk\Repositories\AgentRepository;
use App\HelpDesk\Repositories\TicketRepository;

class TicketController extends Controller
{
    /**
     * @var TicketRepository
     */
    private $repository;
    
    /**
     * TicketController constructor.
     *
     * @param  TicketRepository  $repository
     */
    public function __construct(TicketRepository $repository)
    {
        $this->callMiddlewares();
        $this->repository = $repository;
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
        $userId = auth()->user()->id;
        $tickets = $this->repository->getUserTickets($userId);
        $categories = Category::all();
        //User Tickets
        //Agent Tickets
        //All Tickets -> Admin
//        dd(compact('tickets', 'categories'));
        return view('helpDesk::ticket.index', compact('tickets', 'categories'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $priorities = Priority::all();
        return view('helpDesk::ticket.create', compact('categories', 'priorities'));
    }
    
    
    /**
     * @param  Request          $request
     * @param  AgentRepository  $repository
     *
     * @return Ticket|\Illuminate\Database\Eloquent\Model
     */
    public function store(Request $request, AgentRepository $repository)
    {
        $categoryId = $request->get('category_id');
        $fillables  = [
            'subject'     => 'subject',
            'content'     => 'content',
            'priority_id' => 'priority',
            'category_id' => 'category',
        ];
        $ticket     = [
            'status_id' => config('helpDesk.STATUS_OPEN'),
            'user_id'   => $request->user()->id,
            'agent_id'  => $repository->getActiveAgent($categoryId),
        ];
        foreach ($fillables as $key => $index) {
            $ticket += [
                $key => $request->get($index),
            ];
        }
        $ticket = Ticket::create($ticket);
        return redirect()
            ->back()
            ->with('status', "یک تیکت با شماره #$ticket->id ایجاد شد. ");
    }
    
    
    public function show(Ticket $ticket)
    {
        $category = $ticket->category;
        $user     = $ticket->user;
        $agent    = $ticket->agent;
        return view('helpDesk::ticket.show', compact('ticket', 'category', 'user', 'agent'));
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
