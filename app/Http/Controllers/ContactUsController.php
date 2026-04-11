<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactMessageRequest;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * For Redirect to Contact us page
     */
    public function contactPage()
    {
        return view('contact');
    }

    /**
     * For handle Contact us Form
     */
    public function sendMail(ContactMessageRequest $request)
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to('humayun11998@gmail.com')->send(new ContactUs($user));

        return redirect()->back()->with('success', 'Message Send Successfully');
    }
}
