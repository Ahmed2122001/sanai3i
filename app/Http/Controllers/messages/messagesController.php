<?php

namespace App\Http\Controllers\messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Messages;

class messagesController extends Controller
{
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required',
            'sender_id' => 'required',
            'recipient_id' => 'required',
            'recipient_type' => 'required|in:worker,customer',
        ]);

        $message = new Messages;
        $message->fill($validatedData);
        $message->save();

        return $message;
    }

    public function receive(Request $request)
    {
        $validatedData = $request->validate([
            'recipient_id' => 'required',
            'recipient_type' => 'required|in:worker,customer',
        ]);

        $recipientModel = $validatedData['recipient_type'];
        $recipient = $recipientModel::findOrFail($validatedData['recipient_id']);
        $messages = $recipient->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        return $messages;
    }
}
