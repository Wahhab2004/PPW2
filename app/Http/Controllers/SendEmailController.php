<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Jobs\SendEmailJob;

class SendEmailController extends Controller
{
    public function index()
    {
        return view('emails.sendEmail');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        dispatch(new SendEmailJob($data));
        return redirect()->route('send.email')->with('success', 'Email berhasil dikirim');
    }
}
