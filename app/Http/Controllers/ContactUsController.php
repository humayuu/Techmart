<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Exception;
use Illuminate\Http\Request;
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
    public function sendMail(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'subject' => 'required|max:100',
            'message' => 'required|max:2000',
        ]);

        try {
            $user = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            Mail::to('humayun11998@gmail.com')->send(new ContactUs($user));

            return redirect()->back()->with('success', 'Message Send Successfully');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error in send email '.$e->getMessage());
        }
    }
}
