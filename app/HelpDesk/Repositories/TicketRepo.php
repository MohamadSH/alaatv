<?php


namespace App\HelpDesk\Repositories;

use App\HelpDesk\Models\Ticket;

class TicketRepo
{
    public function submit()
    {

    }

    public function getUserTickets(int $userId)
    {
        return Ticket::where('user_id', $userId)
            ->orWhere('agent_id', $userId)
            ->paginate(20);
    }

    public function toggleOpenClose($id)
    {
        $ticket          = Ticket::find($id);
        $ticket->is_open = ($ticket->is_open == 1) ? 0 : 1;
        return $ticket->save();
    }

    public function assignToAgent($id, $uid)
    {
        $ticket           = Ticket::find($id);
        $ticket->agent_id = $uid;
        $ticket->save();
    }
    // submit a ticket by user
    // submit a ticket by agent
    // change agent (by admin, by agent, by user= false)
    // change text false

    // record events (not now)

    // archive ticket (soft delete)

    // close  (agent, user, admin)
    // open / re-open (by agent, user)
    // change priority (no change)
    // change category ()
    // change status   (open and close is free for all)

    // comment on ticket by agent
    // * delete a comment (not now)
    // * edit comment (not now)

    // notification for comments (on agent reply notif user)

    // index :
    // user tickets
    // agent tickets

}
