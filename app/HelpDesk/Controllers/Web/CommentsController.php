<?php

namespace App\HelpDesk\Controllers\Web;

use App\HelpDesk\Models\Comment;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function addComment($tid)
    {
        $isAnswer = $this->userCanAnswer(auth()->user(), $tid);

    }

    private function userCanAnswer($user, $tid)
    {
        return 1;
    }

    public function answer($tid)
    {
        // authenticate
        // authorize can answer
        $this->validateRequest();
        $this->ensureTicketIsOpen($tid);
        $this->submitCommentCommand($tid);

        respondWith(back()->with('status', 'ok'));
    }

    /**
     * @param Request $request
     */
    private function validateRequest(): void
    {

        $validationRules = [
            'ticket_id' => 'required|exists:' . tickets_table . ',id',
            'content'   => 'required|min:6',
        ];

        $this->validate(request(), $validationRules);
    }

    private function ensureTicketIsOpen()
    {

    }

    /**
     * @param Request $request
     */
    private function submitCommentCommand($tid)
    {
        return $this->submitComment(request('content'), $tid, auth()->id(), auth()->user()->canAnswer($tid));
    }

    /**
     * @param $content
     * @param $ticket_id
     * @param $uid
     */
    private function submitComment($content, $ticket_id, $uid, $is_answer): bool
    {
        $comment            = new Comment();
        $comment->content   = $content;
        $comment->ticket_id = $ticket_id;
        $comment->user_id   = $uid;
        $comment->is_answer = 1;
        return $comment->save();
    }

    public function question()
    {
        $this->validateRequest();
        $this->submitCommentCommand();

        respondWith(back()->with('status', 'ok'));
    }
}
