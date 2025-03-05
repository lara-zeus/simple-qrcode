<?php

use LaraZeus\QrCode\DataTypes\SMS;

beforeEach(function () {
    $this->sms = new SMS;
});
test('it generates a proper format with a phone number', function () {
    $this->sms->create(['555-555-5555']);

    $properFormat = 'sms:555-555-5555';

    expect((string) $this->sms)->toEqual($properFormat);
});
test('it generate a proper format with a message', function () {
    $this->sms->create([null, 'foo']);

    $properFormat = 'sms:&body=foo';

    expect((string) $this->sms)->toEqual($properFormat);
});
test('it generates a proper format with a phone number and message', function () {
    $this->sms->create(['555-555-5555', 'foo']);

    $properFormat = 'sms:555-555-5555&body=foo';

    expect((string) $this->sms)->toEqual($properFormat);
});
