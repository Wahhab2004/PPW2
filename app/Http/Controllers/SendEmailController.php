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

        // $content = [
        //     'name' => 'Ini Nama Pengirim',
        //     'subject' => 'Ini subject email',
        //     'body' => 'Ini adalah isi email yang dikirim dari laravel 10'
        // ];

        // Mail::to('wahhabawaludin2004@mail.ugm.ac.id')->send(new SendEmail($content));

        return view('emails.sendEmail');
    }
    public function store(Request $request)
    {
        // Validasi input dengan pesan error yang lebih deskriptif
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => ['required', 'string', 'max:255', 'not_in:Registration Successful'],
            'body' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.not_in' => 'Subject tidak boleh bernilai "Registration Successful".',
            'body.required' => 'Isi pesan tidak boleh kosong.'
        ]);

        try {
            // Dispatch job untuk mengirim email
            dispatch(new SendEmailJob($validatedData));

            // Redirect dengan pesan sukses
            return redirect()->route('send.email')->with('success', 'Email berhasil dikirim!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
