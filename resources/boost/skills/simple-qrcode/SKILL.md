---
name: zeus-simple-qrcode
description: Generate SVG, PNG, or EPS QR codes and structured payloads (WiFi, SMS, Email, Geo, BTC, Phone) using lara-zeus/simple-qrcode.
---

# Lara Zeus Simple QrCode (`lara-zeus/simple-qrcode`)

## Overview & Requirements
- **Package**: `lara-zeus/simple-qrcode` (Free / MIT)
- **Requirements**: PHP `^8.2`, `ext-gd`, `bacon/bacon-qr-code` `^3.0` (plus `ext-imagick` if generating `png` format)
- **Service Provider & Alias**: Auto-discovered `LaraZeus\QrCode\QrCodeServiceProvider` and `QrCode` alias (`LaraZeus\QrCode\Facades\QrCode`).

## Installation
```bash
composer require lara-zeus/simple-qrcode
```
No configuration file or migrations exist for this package.

## Filament Panel Registration
Not a Filament panel plugin; use `LaraZeus\QrCode\Facades\QrCode` directly in Blade views, Livewire components, controllers, or Filament infolists/views.

## Core Usage & Examples

### Basic Generation & Blade Output
```php
use LaraZeus\QrCode\Facades\QrCode;

// Returns Illuminate\Support\HtmlString (SVG by default)
$svg = QrCode::size(200)->generate('https://larazeus.com');

// Save to a file (returns void)
QrCode::format('svg')->size(300)->generate('https://larazeus.com', public_path('qrcodes/site.svg'));
```
In Blade:
```blade
{!! QrCode::size(150)->generate(request()->url()) !!}

<img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate('Hello')) !!}">
```

### Styling, Colors & Formats
```php
QrCode::format('svg') // 'svg', 'eps', or 'png' (png requires ext-imagick)
    ->size(250)
    ->margin(2)
    ->errorCorrection('H') // 'L', 'M', 'Q', 'H'
    ->encoding('UTF-8')
    ->style('round', 0.5) // 'square', 'dot', or 'round' (size between 0 and < 1)
    ->eye('circle')       // 'square' or 'circle'
    ->color(15, 23, 42)
    ->backgroundColor(255, 255, 255)
    ->eyeColor(0, 255, 0, 0, 0, 0, 0) // eyeNumber: 0, 1, or 2
    ->gradient(255, 0, 0, 0, 0, 255, 'diagonal') // vertical, horizontal, diagonal, inverse_diagonal, radial
    ->generate('Styled QR');
```

### Merging Logos (PNG Only)
```php
QrCode::format('png')
    ->size(300)
    ->errorCorrection('H')
    ->merge('/public/images/logo.png', 0.25) // relative to base_path() unless $absolute = true
    ->generate('https://larazeus.com');

// Or from binary string (e.g. Storage)
QrCode::format('png')
    ->errorCorrection('H')
    ->mergeString(Storage::get('logo.png'), 0.25)
    ->generate('https://larazeus.com');
```

### DataType Helpers
Helpers dynamically resolve `LaraZeus\QrCode\DataTypes\*` via `__call` and immediately call `generate()`:
```php
QrCode::email('foo@bar.com', 'Subject', 'Body');
QrCode::geo(37.822214, -122.481769);
QrCode::phoneNumber('555-555-5555');
QrCode::SMS('555-555-5555', 'Hello', 'smsto'); // format: 'sms' (default), 'smsto', or 'rfc'
QrCode::wiFi(['ssid' => 'MyNet', 'encryption' => 'WPA', 'password' => 'secret', 'hidden' => 'false']);
QrCode::BTC('bitcoin-address', 0.334, ['label' => 'Order #1']);
```

### Usage Outside Laravel
```php
use LaraZeus\QrCode\Generator;

$qr = (new Generator())->size(300)->generate('Standalone');
```

## Common Pitfalls & Anti-Patterns
- **PNG without Imagick**: `format('png')` instantiates `ImagickImageBackEnd`; it throws if the `imagick` PHP extension is missing.
- **Merging on non-PNG**: `merge()` and `mergeString()` are silently ignored unless `format('png')` is set.
- **Calling `generate()` before modifiers**: `generate()` and DataType helpers finalize rendering; chain all configuration methods first.
- **DataType casing**: `Generator::formatClass()` uses `ucfirst($method)`—use exact class names (`BTC`, `SMS`, `wiFi`, `email`, `geo`, `phoneNumber`).
