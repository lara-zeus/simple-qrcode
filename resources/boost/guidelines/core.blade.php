## Lara Zeus Simple QrCode (`lara-zeus/simple-qrcode`)

QR code generator wrapper for Laravel built on `bacon/bacon-qr-code` (fork of `SimpleSoftwareIO/simple-qrcode`).

### Key Classes & Facade
- Facade: `LaraZeus\QrCode\Facades\QrCode` (resolves `LaraZeus\QrCode\Generator` with `clearResolvedInstance()` so each facade call gets a fresh instance)
- Generator: `LaraZeus\QrCode\Generator` (usable directly outside Laravel via `new Generator`)
- ServiceProvider: `LaraZeus\QrCode\QrCodeServiceProvider` (binds `'qrcode'` and provides `Generator::class`)
- DataTypes (`LaraZeus\QrCode\DataTypes\*`, invoked dynamically via `__call`): `BTC`, `Email`, `Geo`, `PhoneNumber`, `SMS`, `WiFi`
- Image helpers: `LaraZeus\QrCode\Image`, `LaraZeus\QrCode\ImageMerge`

### Rules & Pitfalls
- Default output format is `svg`, and in Laravel `generate()` returns an `Illuminate\Support\HtmlString` (unless `$filename` is passed, in which case it writes to disk and returns `void`).
- PNG output (`format('png')`), `merge()`, and `mergeString()` require the PHP `imagick` extension (`ImagickImageBackEnd`) and `ext-gd`; `merge()` / `mergeString()` only apply when `format('png')` is selected.
- Call fluent builder methods (`size()`, `format()`, `color()`, `backgroundColor()`, `gradient()`, `eye()`, `eyeColor()`, `style()`, `margin()`, `encoding()`, `errorCorrection()`) BEFORE `generate()` or DataType helpers (`BTC()`, `email()`, `geo()`, `phoneNumber()`, `SMS()`, `wiFi()`).
- Always use `LaraZeus\QrCode\Facades\QrCode` (not `SimpleSoftwareIO\QrCode\Facades\QrCode`).
