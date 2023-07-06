<?php

namespace App\Http\Controllers\API\contactus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function contactUs(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $message = $request->input('message');

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
        ];

        // Send the email
        Mail::raw("Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message", function ($message) use ($data) {
            $message->to('sanai3i.fcai@gmail.com')
                ->subject('Contact Form Submission');
        });

        // Return a JSON response
        return response()->json(['message' => 'Your message has been sent successfully.']);
    }
}
