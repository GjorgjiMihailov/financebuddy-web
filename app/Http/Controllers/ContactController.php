<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        // Honeypot — ботовите го пополнуваат, луѓето не
        // filled() враќа true само ако е non-null и non-empty (ConvertEmptyStringsToNull го претвора '' → null)
        if ($request->filled('_h')) {
            return redirect()->route('contact.index')->with('success', true);
        }

        $message = ContactMessage::create([
            ...$request->safe()->all(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            Mail::to(config('mail.admin_address'))->send(new NewContactMessage($message));
        } catch (\Exception $e) {
            Log::error('Неуспешно испраќање на контакт email: ' . $e->getMessage());
        }

        return redirect()->route('contact.index')->with('success', true);
    }
}
