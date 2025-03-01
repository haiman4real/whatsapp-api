# WhatsApp API by Emmanuel Ogunwobi

## 📌 Introduction
`whatsapp-api` is a package that enables **sending WhatsApp messages** via **Meta's WhatsApp Cloud API**. It allows you to send **text messages, template messages, and media (images, videos, documents)** directly from your Laravel application.

https://developers.facebook.com/docs/whatsapp/cloud-api/get-started/

---

## 📦 Features
✅ **Send WhatsApp text messages**  
✅ **Send WhatsApp template messages**  
✅ **Send media messages (images, videos, documents)**  
✅ **Uses Meta's WhatsApp Cloud API**  
✅ **Simple service-based architecture**  
✅ **Easy configuration using `.env`**  
✅ **Supports Laravel auto-discovery**  

---

## 📥 Installation
### Install the Package via Composer
```bash
composer require yourvendor/whatsapp-notification
```

### Publish the Configuration File
```bash
php artisan vendor:publish --tag=config
```


### Add API Credentials to .env
```bash
WHATSAPP_ACCESS_TOKEN=your_facebook_whatsapp_api_access_token
WHATSAPP_BUSINESS_PHONE_ID=your_whatsapp_business_phone_id
```

## Usage
### Use the WhatsAppService

Inject the WhatsAppService into your controller:
```php
use Emmaogunwobi\WhatsAppApi\Services\WhatsAppService;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function sendWhatsAppMessage()
    {
        $recipient = '2348123456789'; // WhatsApp number in international format
        $message = "Hello! This is a test message from Laravel.";

        $response = $this->whatsappService->sendMessage($recipient, $message);

        return response()->json($response);
    }
}
```

### Call the API
Start your Laravel app:
```php
php artisan serve
```

Send a request
```php
http://127.0.0.1:8000/api/send-whatsapp
```

## Available Methods

### Send a Custom Text Message
```php
$response = $whatsappService->sendMessage('2348123456789', 'Hello from Laravel!');
```

### 2️⃣ Send a WhatsApp Template Message
```php
$response = $whatsappService->sendTemplateMessage('2348123456789', 'hello_world');
```


### 3️⃣ Send a Media Message (Image, Video, Document)
```php
$response = $whatsappService->sendMediaMessage('2348123456789', 'https://example.com/image.jpg', 'image');
```