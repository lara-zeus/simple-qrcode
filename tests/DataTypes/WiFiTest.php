<?php

use LaraZeus\QrCode\DataTypes\WiFi;

beforeEach(function () {
    $this->wifi = new Wifi;
});
test('it generates a proper format with just the ssid', function () {
    $this->wifi->create([
        0 => [
            'ssid' => 'foo',
        ],
    ]);

    $properFormat = 'WIFI:S:foo;';

    expect((string) $this->wifi)->toEqual($properFormat);
});
test('it generates a proper format for a ssid that is hidden', function () {
    $this->wifi->create([
        0 => [
            'ssid' => 'foo',
            'hidden' => 'true',
        ],
    ]);

    $properFormat = 'WIFI:S:foo;H:true;';

    expect((string) $this->wifi)->toEqual($properFormat);
});
test('it generates a proper format for a ssid encryption and password', function () {
    $this->wifi->create([
        0 => [
            'ssid' => 'foo',
            'encryption' => 'WPA',
            'password' => 'bar',
        ],
    ]);

    $properFormat = 'WIFI:T:WPA;S:foo;P:bar;';

    expect((string) $this->wifi)->toEqual($properFormat);
});
test('it generates a proper format for a ssid encryption password and is hidden', function () {
    $this->wifi->create([
        0 => [
            'ssid' => 'foo',
            'encryption' => 'WPA',
            'password' => 'bar',
            'hidden' => 'true',
        ],
    ]);

    $properFormat = 'WIFI:T:WPA;S:foo;P:bar;H:true;';

    expect((string) $this->wifi)->toEqual($properFormat);
});
