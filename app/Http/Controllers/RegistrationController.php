<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\StudentRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function create()
    {
        return view('registration.create');
    }

    /**
     * Handle a new student registration.
     */
    public function store(RegistrationRequest $request)
    {
        $validated = $request->validated();

        $mailSent = true;

        try {
            Mail::to(config('mail.from.address'))
                ->send(new StudentRegistration(
                    name: $validated['name'],
                    email: $validated['email'],
                    course: $validated['course'],
                    yearLevel: $validated['year_level'],
                ));
        } catch (\Throwable $e) {
            $mailSent = false;

            Log::error('Student registration email failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('registration.create')
            ->with('success', 'Student registered successfully!')
            ->with('mail_failed', ! $mailSent);
    }
}
