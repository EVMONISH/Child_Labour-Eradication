<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AffordMedService
{
    protected $config;

    public function __construct()
    {
        $this->config = config('services.affordmed');
    }

    /**
     * Send a notification to the evaluation service.
     */
    public function sendNotification($type, $data)
    {
        $url = "{$this->config['api_base']}/notifications";
        $token = $this->config['access_token'];

        if (!$token) {
            Log::warning('AffordMed access token not found in .env');
            return false;
        }

        try {
            $response = Http::withToken($token)->post($url, [
                'type' => $type,
                'user' => [
                    'email' => $this->config['email'],
                    'rollNo' => $this->config['roll_no'],
                ],
                'payload' => $data,
                'timestamp' => now()->toIso8601String(),
            ]);

            if ($response->successful()) {
                Log::info("AffordMed notification sent successfully: {$type}");
                return true;
            }

            Log::error("AffordMed notification failed: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("AffordMed notification error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Example method to register/authenticate if needed (not used if token is provided)
     */
    public function authenticate()
    {
        $url = "{$this->config['api_base']}/auth";
        
        $response = Http::post($url, [
            'companyName' => 'Afford Medical Technologies Private Limited',
            'clientID' => $this->config['client_id'],
            'clientSecret' => $this->config['client_secret'],
            'ownerName' => $this->config['name'],
            'ownerEmail' => $this->config['email'],
            'rollNo' => $this->config['roll_no']
        ]);

        return $response->json();
    }
}
