<?php

namespace App\Http\Controllers\API\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Worker;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        try{
            $request->validate([
                'sender_type' => 'required|in:customer,worker',
                'sender_id' => 'required|exists:' . $request->input('sender_type') . ',id',
                'receiver_type' => 'required|in:customer,worker',
                'receiver_id' => 'required|exists:' . $request->input('receiver_type') . ',id',
                'message' => 'required|string',
            ]);

            $message = new Message();
            $message->sender_type = $request->input('sender_type');
            $message->sender_id = $request->input('sender_id');
            $message->receiver_type = $request->input('receiver_type');
            $message->receiver_id = $request->input('receiver_id');
            $message->message = $request->input('message');
//            $message->sender()->associate($senderType === 'customer' ? Customer::find($senderId) : Worker::find($senderId));
//            $message->receiver()->associate($receiverType === 'customer' ? Customer::find($receiverId) : Worker::find($receiverId));
            $message->save();
            event(new MessageSent($message));
            return response()->json(['message' => 'Message sent successfully']);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


    public function getMessages($customerId, $workerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $worker = Worker::findOrFail($workerId);

            $messages = Message::where(function ($query) use ($customer, $worker) {
                $query->where([
                    ['sender_type', 'customer'],
                    ['sender_id', $customer->id],
                    ['receiver_type', 'worker'],
                    ['receiver_id', $worker->id],
                ])->orWhere([
                    ['sender_type', 'worker'],
                    ['sender_id', $worker->id],
                    ['receiver_type', 'customer'],
                    ['receiver_id', $customer->id],
                ]);
            })->orderBy('created_at', 'asc')->get();

            return response()->json(['messages' => $messages]);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
