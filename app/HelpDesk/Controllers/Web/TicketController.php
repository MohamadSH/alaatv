<?php

namespace App\HelpDesk\Controllers;

use App\HelpDesk\Models\Category;
use App\HelpDesk\Models\Priority;
use App\HelpDesk\Models\Ticket;
use App\HelpDesk\Repositories\AgentRepository;
use App\HelpDesk\Repositories\TicketRepo;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * @var TicketRepo
     */
    private $ticketRepo;

    /**
     * TicketController constructor.
     *
     * @param TicketRepo $repository
     */
    public function __construct(TicketRepo $repository)
    {
        $this->callMiddlewares();
        $this->ticketRepo = $repository;
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
        $userId     = auth()->user()->id;
        $tickets    = $this->ticketRepo->getUserTickets($userId);
        $categories = Category::all();
        // User Tickets
        // Agent Tickets
        // All Tickets -> Admin
        return view('helpDesk::ticket.index', compact('tickets', 'categories'));
    }

    public function createForm()
    {
        $categories = Category::all();
        $priorities = Priority::all();
        return view('helpDesk::ticket.create', compact('categories', 'priorities'));
    }

    /**
     * @param Request $request
     *
     * @return Ticket|Model
     */
    public function store(Request $request)
    {
        $categoryId = request('category_id');

        $ticket = [
            'status_id' => config('helpDesk.STATUS_OPEN'),
            'user_id'   => $request->user()->id(),
            'agent_id'  => resolve(AgentRepository::class)->getActiveAgent($categoryId),
        ];

        $data = $request->only(['subject', 'content', 'priority_id', 'category_id',]);

        $ticket = Ticket::create($ticket + $data);


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

    public function toggleIsOpen($ticket_id)
    {
        return $result = resolve(TicketRepo::class)->toggleOpenClose($ticket_id);
        // validate request. $id exists.
        // log event.
        // notify agent and user.
    }
}
