<?php

namespace Emmaogunwobi\WhatsappApi\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $accessToken;
    protected $phoneId;

    public function __construct()
    {
        $this->accessToken = config('whatsapp.access_token');
        $this->phoneId = config('whatsapp.business_phone_id');
    }

    public function sendTemplateMessage($recipient, $templateName = 'hello_world', $languageCode = 'en_US')
    {
        $url = "https://graph.facebook.com/v22.0/{$this->phoneId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $recipient,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => ['code' => $languageCode]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json',
            ])->post($url, $payload);

            $result = $response->json();

            Log::info('WhatsApp API Response', ['response' => $result]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $result];
            } else {
                return ['success' => false, 'error' => $result];
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Send a WhatsApp Text Message
     */
    public function sendMessage($recipient, $message)
    {
        $url = "https://graph.facebook.com/v22.0/{$this->phoneId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $recipient,
            'type' => 'text',
            'text' => ['body' => $message]
        ];

        return $this->sendRequest($url, $payload);
    }

    /**
     * Send a Media Message (Image, Video, Document)
     */
    public function sendMediaMessage($recipient, $mediaUrl, $mediaType = 'image')
    {
        $url = "https://graph.facebook.com/v22.0/{$this->phoneId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $recipient,
            'type' => $mediaType,
            $mediaType => ['link' => $mediaUrl]
        ];

        return $this->sendRequest($url, $payload);
    }

    /**
     * Execute the API Request
     */
    private function sendRequest($url, $payload)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json',
            ])->post($url, $payload);

            $result = $response->json();
            Log::info('WhatsApp API Response', ['response' => $result]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $result];
            } else {
                return ['success' => false, 'error' => $result];
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}