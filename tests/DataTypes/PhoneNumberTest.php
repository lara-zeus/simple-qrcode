<?php

use LaraZeus\QrCode\DataTypes\PhoneNumber;

test('it generates the proper format for calling a phone number', function () {
    $phoneNumber = new PhoneNumber;
    $phoneNumber->create(['555-555-5555']);

    $properFormat = 'tel:555-555-5555';

    expect((string) $phoneNumber)->toEqual($properFormat);
});
