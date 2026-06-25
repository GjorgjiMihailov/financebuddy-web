<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255']);

        $response = Http::withHeaders([
            'api-key'      => config('services.brevo.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/contacts', [
            'email'         => $request->email,
            'listIds'       => [config('services.brevo.newsletter_list_id')],
            'updateEnabled' => true,
        ]);

        // 201 = нов контакт, 204 = веќе постои (updateEnabled го ажурира)
        if ($response->successful()) {
            return response()->json(['success' => true]);
        }

        Log::error('Brevo newsletter грешка', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        return response()->json(['error' => 'Грешка при зачувување. Обидете се повторно.'], 500);
    }
}
