# OrvexPay PHP SDK

Official PHP SDK for the OrvexPay Payment Gateway.

## Installation

Install via Composer:

```bash
composer require orvexpay/sdk
```

## Usage

### Initialize the Client

```php
use OrvexPay\Sdk\OrvexClient;

$client = new OrvexClient('your-api-key');
```

### Create an Invoice

```php
try {
    $invoice = $client->createInvoice([
        'priceAmount' => '100.00',
        'priceCurrency' => 'USD',
        'payCurrency' => 'USDT',
        'successUrl' => 'https://your-site.com/success',
        'cancelUrl' => 'https://your-site.com/cancel',
        'orderId' => 'Order-123',
        'orderDescription' => 'Test Payment'
    ]);

    echo "Invoice Created: " . $invoice['id'];
} catch (\OrvexPay\Sdk\Exceptions\OrvexException $e) {
    echo $e->getMessage();
}
```

### Get Invoice Details

```php
$invoice = $client->getInvoice('invoice-id');
echo "Status: " . $invoice['status'];
```

### Change Invoice Currency

```php
$updatedInvoice = $client->updateInvoiceCurrency('invoice-id', 'BTC');
```

## Features

- Simple and modern PHP implementation.
- PSR-4 autoloading compliant.
- Built-in exception handling.
- Guzzle powered for reliable HTTP communication.
